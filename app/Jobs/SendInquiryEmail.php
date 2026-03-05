<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;
use App\Mail\PopUpInquiry;


class SendInquiryEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     * * * * * * /usr/local/bin/php /www/wwwroot/3.6.39.134/knote/path/to/artisan queue:work --sleep=3 --tries=3 >> /dev/null 2>&1
     /www/server/php/ /www/wwwroot/3.6.39.134/knote/artisan queue:work --sleep=3 --tries=3 >> /dev/null 2>&1
     * @return void
     */
    protected $inquiry;


    public function __construct($inquiry)
    {
        //
        $this->inquiry = $inquiry;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to([config('constants.contact_inquiry_receiver_email'), config('constants.contact_inquiry_receiver_email_cc')])->send(new PopUpInquiry($this->inquiry));
    }
}
