<?php
namespace Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public static function send($to, $subject, $body, $from = null, $fromName = null)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 't_vantiep@thk-hd.vn';
            $mail->Password   = 'pgni xjqh mloi kgmf';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom($from ?: 't_vantiep@thk-hd.vn', $fromName ?: 'Demo FuelPHP');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            \Log::error("Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
