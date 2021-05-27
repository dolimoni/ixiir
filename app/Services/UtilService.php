<?php


namespace App\Services;

use App\Models\Post;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UtilService {

    use Queueable, SerializesModels;

    function __construct()
    {

    }

    public function send(){

        $data = ['message' => 'This is a test!'];

        Mail::to('salahchahin765@gmail.com')->send(new EmailService($data));
    }
}