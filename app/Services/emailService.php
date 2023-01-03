<?php

namespace App\Services;

use Carbon\Carbon;
use App\Mail\notification;
use Illuminate\Support\Facades\Mail;


class emailService {
    public function sendEmail($mensaje,$usuario, $subject)
    {
        $fecha = carbon::now();
        $response = Mail::to('gespinoza@formunica.com','Gabriel Espinoza')->queue(new notification($mensaje,$usuario,$subject,$fecha));
    }
}
