<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WorkplaceSendMail;
use App\Models\Workplace;
use App\Models\Employee;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Workplace $workplace,
        private Employee $employee,
        private string $implementation_date,
        private string $type
    ) {
        $this->workplace = $workplace;
        $this->employee = $employee;
        $this->implementation_date = $implementation_date;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->employee->email)
            ->send(new WorkplaceSendMail(
                $this->workplace,
                $this->employee,
                $this->implementation_date,
                $this->type)
        );
    }
}
