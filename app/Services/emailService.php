<?php

namespace App\Services;

use Carbon\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use App\Mail\notification;
use Illuminate\Support\Facades\Mail;
use App\Http\Common\templateEmail;


class emailService
{
    public function sendEmail($mensaje,$usuario, $subject)
    {
        $fecha = carbon::now();
        $response = Mail::to('rnorori@formunica.com','Roxana Norori')->queue(new notification($mensaje,$usuario,$subject,$fecha));
    }
    public function enviarEmail($usuario, $monto, $mensaje, $email,$subject)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = "smtp.office365.com";
            $mail->SMTPAuth = true;
            $mail->Username = "app@formunica.com";
            $mail->Password = "Nicaragua2022#$";
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('app@formunica.com', 'Sistema Formunica');
            $mail->addAddress($email,"Formunica");
            $mail->isHtml(true);
            $mail->Subject = $subject;
            $mail->Body = templateEmail::getTemplate($usuario,$monto, $mensaje);
            $mail->AltBody = "Este correo a sido generado por sistema";
            $mail->send();

           /* if(!$mail->send())
            {
                return back()->with("failed","Email not sent")->withErrors($mail->ErrorInfo);
            /*} else {
                return back()->with("success", "Email has been sent.");
            }*/
        } catch(Exception $e) {
            return back()->with('error','Error en el envío del correo');
        }
    }
}
