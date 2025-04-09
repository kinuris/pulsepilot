<?php

namespace App\Livewire;

use App\Models\DoctorAppointment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class CalendarView extends Component
{
    #[Url(as: 'd')]
    public $view = 'day';

    public bool $showCreateModal = false;

    public $appointmentDate;

    public $appointmentTime;
    public $appointmentEndTime;
    public $appointmentReason;
    public $appointmentNotes;

    public $durationMinutes = 15;
    public $currentDate;

    public $availableTimeSlots = [];

    public $patientId = '';

    public $viewedAppointment = null;
    public $viewedAppointmentStatus;

    public function mount()
    {
        $this->currentDate = date('Y-m-d');
        $this->loadAvailableTimeSlots();
    }

    #[Computed]
    public function existingSchedules()
    {
        return DoctorAppointment::query()
            ->where('user_id', Auth::user()->id)
            ->get();
    }

    public function updateAppointmentStatus()
    {
        $this->validate([
            'viewedAppointmentStatus' => 'required|in:Pending,Confirmed,Completed,Canceled,Rescheduled,No-Show'
        ]);

        $appointment = DoctorAppointment::query()->find($this->viewedAppointment['id']);
        $appointment->status = $this->viewedAppointmentStatus;

        $this->viewedAppointment['status'] = $this->viewedAppointmentStatus;

        $appointment->save();
    }

    public function viewAppointment(DoctorAppointment $schedule)
    {
        $this->viewedAppointment = $schedule->with('patient')->find($schedule->id)->toArray();
        $this->viewedAppointmentStatus = $this->viewedAppointment['status'];
    }

    public function nextPeriod()
    {
        if ($this->view === 'day') {
            $this->currentDate = \Carbon\Carbon::parse($this->currentDate)->addDay()->format('Y-m-d');
        } elseif ($this->view === 'week') {
            $this->currentDate = \Carbon\Carbon::parse($this->currentDate)->addWeek()->format('Y-m-d');
        } else { // month view
            $this->currentDate = \Carbon\Carbon::parse($this->currentDate)
                ->startOfMonth()
                ->addMonth()
                ->format('Y-m-d');
        }
    }

    public function previousPeriod()
    {
        if ($this->view === 'day') {
            $this->currentDate = \Carbon\Carbon::parse($this->currentDate)->subDay()->format('Y-m-d');
        } elseif ($this->view === 'week') {
            $this->currentDate = \Carbon\Carbon::parse($this->currentDate)->subWeek()->format('Y-m-d');
        } else { // month view
            $this->currentDate = \Carbon\Carbon::parse($this->currentDate)
                ->startOfMonth()
                ->subMonth()
                ->format('Y-m-d');
        }
    }

    public function createAppointment()
    {
        // Validate input
        $this->validate([
            'appointmentDate' => 'required|date',
            'appointmentTime' => 'required',
            'appointmentEndTime' => 'required',
            'appointmentReason' => 'required',
            'patientId' => 'required|exists:patients,id'
        ]);

        // Create appointment
        $appointment = new DoctorAppointment();
        $appointment->user_id = Auth::user()->id;
        $appointment->patient_id = $this->patientId;
        $appointment->appointment_date = $this->appointmentDate;
        $appointment->appointment_time = $this->appointmentTime;
        $appointment->duration_minutes = $this->durationMinutes;
        $appointment->notes = $this->appointmentNotes;
        $appointment->status = 'Pending';
        $appointment->reason = 'General Consultation';

        $appointment->save();

        // Reset form
        $this->appointmentDate = null;
        $this->appointmentTime = null;
        $this->appointmentEndTime = null;
        $this->patientId = null;

        // Close modal
        $this->showCreateModal = false;

        // Refresh available time slots
        $this->loadAvailableTimeSlots();
    }

    public function selectTimeSlot($start, $end)
    {
        $this->appointmentTime = $start;
        $this->appointmentEndTime = $end;

        $this->showCreateModal = true;
    }

    public function getStatusColor($status)
    {
        return match ($status) {
            'Pending' => 'yellow',
            'Confirmed' => 'blue',
            'Completed' => 'green',
            'Canceled' => 'red',
            'Rescheduled' => 'purple',
            'No-Show' => 'gray',
            default => 'gray',
        };
    }

    public function loadAvailableTimeSlots()
    {
        // Ensure appointmentDate is set
        if (!$this->appointmentDate) {
            $this->appointmentDate = date('Y-m-d'); // Default to today
        }

        $this->appointmentTime = null;
        $this->appointmentEndTime = null;

        // Define standard business hours
        $startTime = strtotime('09:00:00');
        $endTime = strtotime('17:00:00');
        $lunchStart = strtotime('12:00:00');
        $lunchEnd = strtotime('13:00:00');

        $this->availableTimeSlots = [];
        $duration = $this->durationMinutes;

        $currentTime = $startTime;
        while ($currentTime + ($duration * 60) <= $endTime) {
            // Skip lunch time
            if ($currentTime >= $lunchStart && $currentTime < $lunchEnd) {
                $currentTime = $lunchEnd;
                continue;
            }

            $slotStart = date('H:i:s', $currentTime);
            $slotEnd = date('H:i:s', $currentTime + ($duration * 60));

            // Check for collision with existing appointments
            $hasCollision = $this->existingSchedules()
                ->where('appointment_date', $this->appointmentDate)
                ->some(function ($appointment) use ($slotStart, $slotEnd) {
                    $appointmentStart = $appointment->appointment_time;
                    $appointmentEnd = date('H:i:s', strtotime($appointment->appointment_time) + ($appointment->duration_minutes * 60));

                    // Check if this slot overlaps with an existing appointment
                    return ($slotStart < $appointmentEnd && $slotEnd > $appointmentStart);
                });

            // Only add the slot if there's no collision
            if (!$hasCollision) {
                $this->availableTimeSlots[] = [
                    'start' => $slotStart,
                    'end' => $slotEnd
                ];
            }

            $currentTime += ($duration * 60);
        }
    }

    public function setView($view)
    {
        $this->currentDate = date('Y-m-d');

        $this->view = $view;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.calendar-view');
    }
}
