<?php

namespace App\Http\Controllers;

use App\Jobs\SendGeneralEmail;
use App\Models\ActivityRecord;
use App\Models\BmiRecord;
use App\Models\ChatMessage;
use App\Models\Connection;
use App\Models\DoctorAppointment;
use App\Models\GlucoseRecord;
use App\Models\ImmunizationHistory;
use App\Models\LabRequest;
use App\Models\LabSubmission;
use App\Models\MedicationRecord;
use App\Models\NutritionRecord;
use App\Models\PastConditionHistory;
use App\Models\Patient;
use App\Models\User;
use App\Models\WaterRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
    public function revokeDoctor(Request $request, Patient $patient, User $doctor)
    {
        Connection::query()
            ->where('patient_id', $patient->id)
            ->where('user_id', $doctor->id)
            ->delete();

        $doctorName = $doctor->name; // Assuming User model has a 'name' attribute
        $patientName = $patient->first_name . ' ' . $patient->last_name;

        $emailSubject = 'PulsePilot: Patient Connection Revoked';
        $emailBody = '
    <div style="font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; max-width: 600px; margin: 20px auto; padding: 25px; border: 1px solid #e0e0e0; border-radius: 8px; background-color: #f9f9f9;">
        <div style="text-align: center; padding-bottom: 15px; border-bottom: 1px solid #cccccc; margin-bottom: 25px;">
        <h1 style="color: #c9302c; font-size: 24px; margin: 0; font-weight: 500;">Connection Revoked</h1>
        </div>
        <p style="font-size: 16px; line-height: 1.6; color: #333333;">Dear ' . htmlspecialchars($doctorName) . ',</p>
        <p style="font-size: 16px; line-height: 1.6; color: #333333;">This email serves as confirmation that your connection with patient <strong>' . htmlspecialchars($patientName) . '</strong> has been revoked within the PulsePilot platform.</p>
        <p style="font-size: 16px; line-height: 1.6; color: #333333;">Consequently, you will no longer have access to this patient\'s health records or the ability to interact with them through the PulsePilot system.</p>
        <p style="font-size: 16px; line-height: 1.6; color: #333333;">Should you believe this action was performed in error, please contact the patient directly or reach out to PulsePilot support for assistance.</p>
        <p style="font-size: 16px; line-height: 1.6; color: #333333; margin-top: 30px;">Thank you for your understanding.</p>
        <p style="font-size: 16px; line-height: 1.6; color: #333333;">Sincerely,</p>
        <p style="font-size: 16px; line-height: 1.6; color: #333333; font-weight: bold;">The PulsePilot Team</p>
        <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #cccccc; font-size: 12px; color: #777777; text-align: center;">
        <p>This is an automated notification. Please do not reply to this email.</p>
        <p>&copy; ' . date('Y') . ' PulsePilot. All rights reserved.</p>
        </div>
    </div>';

        SendGeneralEmail::dispatch(
            $doctor->email,
            $emailSubject,
            $emailBody
        );

        return response()->json([
            'message' => 'Doctor connection revoked successfully.',
        ]);
    }

    public function getAppointments(Request $request, Patient $patient)
    {
        $appointments = DoctorAppointment::query()
            ->where('patient_id', $patient->id)
            ->with(['doctor'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json($appointments);
    }

    public function createAppointment(Request $request, User $user, Patient $patient)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:15|max:120',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        if (!$user || !$patient) {
            return response()->json([
                'message' => 'Doctor or Patient not found.',
            ], 404);
        }

        $date = date_create($request->input('date'))->format('Y-m-d');
        $appointmentDateTime = date('H:i:s', strtotime($date . ' ' . $request->input('time')));
        $appointmentEndTime = date('H:i:s', strtotime($appointmentDateTime) + (((int) $request->input('duration')) * 60));

        $hasCollision = DoctorAppointment::query()
            ->where('user_id', '=', $user->id)
            ->where('appointment_date', '=', date('Y-m-d', strtotime($request->input('date'))))
            // ->whereNotIn('status', ['canceled', 'rescheduled'])
            ->get()
            ->filter(function ($appointment) use ($appointmentDateTime, $appointmentEndTime) {
                $existingStart = $appointment->appointment_time;
                // $existingEnd = $existingStart + ($appointment->duration_minutes * 60);
                $existingEnd = date('H:i:s', strtotime($appointment->appointment_time) + ($appointment->duration_minutes * 60));

                return ($appointmentDateTime < $existingEnd && $appointmentEndTime > $existingStart);
            })
            ->isNotEmpty();

        if ($hasCollision) {
            return response()->json([
                'slotna' => 'The selected time slot is not available.',
            ], 400);
        }

        $appointment = new DoctorAppointment();

        $appointment->user_id = $user->id;
        $appointment->patient_id = $patient->id;
        $appointment->appointment_date = $request->input('date');
        $appointment->appointment_time = $request->input('time');
        $appointment->status = 'pending';
        $appointment->duration_minutes = $request->input('duration');
        $appointment->reason = $request->input('reason');
        $appointment->notes = $request->input('notes');

        $appointment->save();

        return response()->json([
            'message' => 'Appointment created successfully.',
            'data' => $appointment,
        ]);
    }

    public function getTimeSlots(Request $request, User $user)
    {
        $date = $request->json('date');
        if (!$date) {
            return response()->json([
                'message' => 'The date field is required.',
            ], 400);
        }

        // Define standard business hours
        $startTime = strtotime('09:00:00');
        $endTime = strtotime('17:00:00');
        $lunchStart = strtotime('12:00:00');
        $lunchEnd = strtotime('13:00:00');

        $timeSlots = [
            "15" => [],
            "30" => [],
            "45" => [],
            "60" => []
        ];

        foreach ([15, 30, 45, 60] as $duration) {
            $currentTime = $startTime;
            while ($currentTime + ($duration * 60) <= $endTime) {
                if ($currentTime >= $lunchStart && $currentTime < $lunchEnd) {
                    $currentTime = $lunchEnd;
                    continue;
                }

                $slotStart = date('H:i:s', $currentTime);
                $slotEnd = date('H:i:s', $currentTime + ($duration * 60));

                // Check for collision with existing appointments
                $hasCollision = DoctorAppointment::query()
                    ->where('user_id', '=', $user->id)
                    ->where('appointment_date', '=', date('Y-m-d', strtotime($date)))
                    // ->whereNotIn('status', ['canceled', 'rescheduled'])
                    ->get()
                    ->filter(function ($appointment) use ($slotStart, $slotEnd) {
                        $appointmentStart = $appointment->appointment_time;
                        $appointmentEnd = date('H:i:s', strtotime($appointment->appointment_time) + ($appointment->duration_minutes * 60));

                        // Check if this slot overlaps with an existing appointment
                        return ($slotStart < $appointmentEnd && $slotEnd > $appointmentStart);
                    })
                    ->isNotEmpty();

                // Only add the slot if there's no collision
                if (!$hasCollision) {
                    $timeSlots["$duration"][] = [
                        'start' => $slotStart,
                        'end' => $slotEnd
                    ];
                }

                $currentTime += ($duration * 60);
            }
        }

        return response()->json($timeSlots);
    }

    public function recoverData($recoveryId)
    {
        $patient = Patient::query()
            ->with(['bmiRecords', 'waterRecords', 'glucoseRecords', 'nutritionRecords', 'activityRecords'])
            ->where('recovery_id', $recoveryId)
            ->first();

        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found',
            ], 404);
        }

        return response()->json($patient);
    }

    public function pingOnline(Request $request, Patient $patient)
    {
        $expiresAt = now()->addMinutes(1);
        $key = 'patient-online-' . $patient->id;

        Cache::put($key, true, $expiresAt);
        Cache::forever('most-recent-patient-online-' . $patient->id, now());

        return response()->json([
            'message' => 'Ping successful',
        ]);
    }

    public function getOnlineDoctors(Request $request, Patient $patient)
    {
        $doctors = $patient->connections()
            ->get()
            ->map(fn($connection) => $connection->doctor);

        $onlineDoctors = $doctors->filter(function ($doctor) {
            return Cache::has('online-' . $doctor->id);
        });

        return response()->json($onlineDoctors);
    }

    public function sendChatMessage(Request $request, User $doctor)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'message_type' => 'required|in:text,image,pdf',
            'message' => 'required_if:message_type,text',
            'file' => 'required_if:message_type,image,pdf|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $chatMessage = new ChatMessage();
        $chatMessage->sender_type = 'patient';
        $chatMessage->message_type = $request->input('message_type');
        $chatMessage->patient_id = $request->input('patient_id');
        $chatMessage->user_id = $doctor->id;

        if ($request->input('message_type') === 'text') {
            $chatMessage->message = $request->input('message');
        } else {
            $file = $request->file('file');
            $chatMessage->path = $file->store('chat-attachments', 'public');
        }

        $chatMessage->save();

        return response()->json([
            'message' => 'Chat message sent successfully',
            'data' => $chatMessage
        ]);
    }

    public function getMonitoringDoctors(Request $request, Patient $patient)
    {
        $doctors = $patient->connections()
            ->get()
            ->map(fn($connection) => $connection->doctor);

        return response()->json($doctors);
    }

    public function getChatBatch(Request $request, Patient $patient, User $doctor)
    {
        $request->validate([
            'from_message_id' => 'nullable|integer',
        ]);

        $fromMessageId = $request->input('from_message_id');

        $query = ChatMessage::query()
            ->with(['doctor', 'patient'])
            ->where('patient_id', $patient->id)
            ->where('user_id', $doctor->id);

        if ($fromMessageId) {
            $query->where('id', '<', $fromMessageId);
        }

        $query = $query->orderBy('created_at', 'desc');

        $messages = $query->get();

        return response()->json($messages);
    }

    public function createPatient(Request $request)
    {
        $patient = new Patient();

        $patient->first_name = $request->json('first_name');
        $patient->middle_name = $request->json('middle_name');
        $patient->last_name = $request->json('last_name');
        $patient->birthdate = $request->json('birthdate');
        $patient->province = $request->json('province');
        $patient->municipality = $request->json('municipality');
        $patient->barangay = $request->json('barangay');
        $patient->zip_code = $request->json('zip_code');
        $patient->address_description = $request->json('address_description');
        $patient->sex = $request->json('sex');
        $patient->contact_number = $request->json('contact_number');
        $patient->recovery_id = Patient::genUniqueRecoveryId();

        $patient->save();
        $patient = $patient->refresh();

        return response()->json([
            'message' => 'Patient created successfully',
            'web_id' => $patient->id,
            'recovery_id' => $patient->recovery_id,
        ]);
    }


    public function submitLabResult(Request $request, Patient $patient)
    {
        $request->validate([
            'request_id' => 'required|exists:lab_requests,id',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $labRequest = LabRequest::query()->find($request->input('request_id'));

        $labResult = new LabSubmission();
        $labResult->lab_request_id = $labRequest->id;

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $labResult->type = in_array($extension, ['jpg', 'jpeg', 'png']) ? 'image' : 'file';

        $labResult->file_path = $file->store('lab-results', 'public');
        $labResult->save();

        return response()->json([
            'message' => 'Lab result submitted successfully',
        ]);
    }

    public function syncGlucoseRecords(Request $request, Patient $patient)
    {
        GlucoseRecord::query()->where('patient_id', $patient->id)->delete();

        foreach ($request->json('records') as $record) {
            $glucose = new GlucoseRecord();

            $glucose->patient_id = $patient->id;
            $glucose->notes = $record['notes'];
            $glucose->glucose_level = $record['glucose_level'];
            $glucose->is_a1c = $record['is_a1c'];
            $glucose->recorded_at = $record['blood_test_date'];

            $glucose->save();
        }

        return response()->json([
            'message' => 'Glucose records synced successfully',
        ]);
    }

    public function syncBmiRecords(Request $request, Patient $patient)
    {
        BmiRecord::query()->where('patient_id', $patient->id)->delete();

        foreach ($request->json('records') as $record) {
            $bmi = new BmiRecord();

            $bmi->patient_id = $patient->id;
            $bmi->notes = $record['notes'];
            $bmi->weight = $record['weight'];
            $bmi->height = $record['height'];
            $bmi->recorded_at = $record['recorded_at'];

            $bmi->save();
        }

        return response()->json([
            'message' => 'BMI records synced successfully',
        ]);
    }

    public function syncActivityRecords(Request $request, Patient $patient)
    {
        ActivityRecord::query()->where('patient_id', $patient->id)->delete();

        foreach ($request->json('records') as $record) {
            $activity = new ActivityRecord();

            $activity->patient_id = $patient->id;
            $activity->type = $record['type'];
            $activity->duration = $record['duration'];
            $activity->frequency = $record['frequency'];
            $activity->notes = $record['notes'];
            $activity->recorded_at = $record['recorded_at'];

            $activity->save();
        }

        return response()->json([
            'message' => 'Activity records synced successfully',
        ]);
    }

    public function syncMedicationRecords(Request $request, Patient $patient)
    {
        MedicationRecord::query()->where('patient_id', $patient->id)->delete();

        foreach ($request->json('records') as $record) {
            $medication = new MedicationRecord();

            $medication->patient_id = $patient->id;
            $medication->medicine_name = $record['medicine_name'];
            $medication->medicine_route = $record['medicine_route'];
            $medication->medicine_dosage = $record['medicine_dosage'];
            $medication->medicine_form = $record['medicine_form'];
            $medication->medication_reminder_date = $record['medication_reminder_date'];
            $medication->recorded_time_taken = $record['recorded_time_taken'];

            $medication->save();
        }

        return response()->json([
            'message' => 'Medication records synced successfully',
        ]);
    }

    public function syncNutritionRecords(Request $request, Patient $patient)
    {
        NutritionRecord::query()->where('patient_id', $patient->id)->delete();

        foreach ($request->json('records') as $record) {
            $nutrition = new NutritionRecord();

            $nutrition->patient_id = $patient->id;
            $nutrition->notes = $record['notes'];
            $nutrition->day_description = $record['day_description'];
            $nutrition->foods_csv = $record['foods_csv'];
            $nutrition->recorded_at = $record['recorded_at'];

            $nutrition->save();
        }

        return response()->json([
            'message' => 'Nutrition records synced successfully',
        ]);
    }

    public function syncWaterRecords(Request $request, Patient $patient)
    {
        WaterRecord::query()->where('patient_id', $patient->id)->delete();

        foreach ($request->json('records') as $record) {
            $water = new WaterRecord();

            $water->patient_id = $patient->id;
            $water->glasses = $record['glasses'];
            $water->recorded_at = $record['recorded_at'];

            $water->save();
        }

        return response()->json([
            'message' => 'Water records synced successfully',
        ]);
    }

    public function syncPatient(Request $request, Patient $patient)
    {
        $patient->first_name = $request->json('first_name');
        $patient->middle_name = $request->json('middle_name');
        $patient->last_name = $request->json('last_name');
        $patient->birthdate = $request->json('birthdate');
        $patient->province = $request->json('province');
        $patient->municipality = $request->json('municipality');
        $patient->barangay = $request->json('barangay');
        $patient->zip_code = $request->json('zip_code');
        $patient->address_description = $request->json('address_description');

        $patient->save();

        return response()->json([
            'message' => 'Patient updated successfully',
        ]);
    }

    public function getPatientLabRequest(Patient $patient)
    {
        $requests = LabRequest::query()
            ->where('patient_id', $patient->id)
            ->with(['patient', 'doctor', 'labSubmission'])
            ->get();

        return $requests->toArray();
    }

    public function getImmunizationHistory(Patient $patient)
    {
        $immunizations = ImmunizationHistory::with('patient')
            ->where('patient_id', $patient->id)
            ->get();

        return $immunizations->toArray();
    }

    public function getConditionHistory(Patient $patient)
    {
        $conditions = PastConditionHistory::with('patient')
            ->where('patient_id', $patient->id)
            ->get();

        return $conditions->toArray();
    }
}
