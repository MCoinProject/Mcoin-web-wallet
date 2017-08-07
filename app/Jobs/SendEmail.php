<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\User;
use App\Http\Controllers\EmailController;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $amount;
    protected $address;
    protected $code;
    protected $type;
    protected $targetEmail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $amount, $address, $code, $targetEmail, $type)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->address = $address;
        $this->code = $code;
        $this->type = $type;
        $this->targetEmail = $targetEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $amount = $this->amount;
        $address = $this->address;
        $code = $this->code;
        $type = $this->type;
        $targetEmail = $this->targetEmail;

        $mailer = new EmailController();

        // Execute function to send email depending on type conditions
        if($type == 'transfer') {
            $mailer->notifyTransfer($user, $amount, $address, $code);
        } else if($type == 'request') {
            $mailer->notifyRequest($targetEmail, $user, $amount);
        } else {
            $mailer->notifyReceive($targetEmail, $user, $amount);
        }
    }
}
