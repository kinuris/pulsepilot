<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendGeneralEmail implements ShouldQueue
{
    use Queueable;

    protected $to;
    protected $subject;
    protected $body;

    /**
     * Create a new job instance.
     */
    public function __construct(string $to, string $subject, string $body)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Sending email', [
            'to' => $this->to,
            'subject' => $this->subject,
            'body' => $this->body,
        ]);

        $genericEmailUrl = env('ZAPIER_GENERIC_EMAIL_URL');
        $response = Http::post($genericEmailUrl, [
            'email' => $this->to,
            'subject' => $this->subject,
            'content' => $this->body,
        ]);

        if ($response->failed()) {
            Log::error('Failed to send email', [
                'to' => $this->to,
                'subject' => $this->subject,
                'body' => $this->body,
                'response' => $response->body(),
            ]);

            return;
        }
    }
}
