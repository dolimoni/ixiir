<?php


namespace App\Services;

use App\Models\Post;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailService extends Mailable {

    use Queueable, SerializesModels;

    function __construct()
    {

    }

    public function build()
    {
        $address = 'contact@generaleperformance.ma';
        $subject = 'Reset password v1';
        $name = 'ixiir';

        return $this->view('emails.reset_password')
            ->from($address, $name)
            ->subject($subject)
            ->with([ array()]);
    }


}