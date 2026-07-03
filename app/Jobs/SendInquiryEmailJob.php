<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendInquiryEmailJob implements ShouldQueue
{
    use Queueable;

    public $data;
    public $subjectLine;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $subjectLine)
    {
        $this->data = $data;
        $this->subjectLine = $subjectLine;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Illuminate\Support\Facades\Mail::send('emails.inquiry', $this->data, function ($message) {
            $message->to(config('mail.to_address', 'sales@epignosisinsights.com'))
                    ->subject($this->subjectLine);
        });
    }
}
