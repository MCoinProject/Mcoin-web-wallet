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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $amount, $address, $code, $type)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->address = $address;
        $this->code = $code;
        $this->type = $type;
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

        $mailer = new EmailController();

        if($type == 'transfer') {
            $mailer->notifyTransfer($user, $amount, $address, $code);
        } else {
            // $mailer->notifyTransfer($user, $amount, $address, $code);
        }
    }
}
