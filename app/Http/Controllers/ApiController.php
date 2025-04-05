<?php

namespace App\Http\Controllers;

use App\Models\ActivityRecord;
use App\Models\BmiRecord;
use App\Models\ChatMessage;
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

class ApiController extends Controller
{
    public function sendChatMessage(Request $request, User $doctor) {
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
        return response()->json([
            'message' => 'Water records synced successfully',
        ]);

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
