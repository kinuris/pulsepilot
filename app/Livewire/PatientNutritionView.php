<?php

namespace App\Livewire;

use App\Models\NutritionRecord;
use App\Models\Patient;
use GuzzleHttp\Client;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class PatientNutritionView extends Component
{
    #[Reactive]
    public Patient $patient;

    public function genAINotes(NutritionRecord $record) {
        $client = new Client();

        $response = $client->post('https://api.openai.com/v1/responses', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ],
            'json' => [
                'model' => 'gpt-4o',
                'input' => <<<PROMPT
                    **Return a Markdown Formatted Response**

                    Pretend that you are an Expert Nutritionist. 
                    Generate a 40 word summary of the following foods with nutrition commentary, 
                    give the estimated calorie count breakdown for each food item as well as the total calorie count: 
                    {$record->foods_csv}
                    PROMPT,

            ]
        ]);

        $output = json_decode($response->getBody()->getContents())->output[0]->content;
        $output = collect($output);

        return $output->first()->text;
    }

    #[Computed]
    public function nutritionRecords()
    {
        return $this->patient->nutritionRecords()->orderBy('recorded_at', 'desc');
    }

    #[Computed]
    public function nutritionRecordsPaginated()
    {
        return NutritionRecord::whereIn('id', $this->nutritionRecords()->pluck('id'))->orderBy('recorded_at', 'desc')->paginate();
    }

    #[Computed]
    public function latestRecord()
    {
        return $this->nutritionRecords->first();
    }

    public function render()
    {
        return view('livewire.patient-nutrition-view');
    }
}
