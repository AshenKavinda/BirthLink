<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
class Mailer {

    private $mail;
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        // SMTP configuration
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'designer4u2d@gmail.com'; // Your Gmail username
        $this->mail->Password = 'nicc xpsn enxj hhiq'; // Your Gmail app password (not your Gmail password)
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->Port = 465;

        // Sender and recipient settings
        $this->mail->setFrom('designer4u2d@gmail.com', 'Ashen');
    }

    public function send($toEmail,$subject,$message) {
        try {
            
            $this->mail->addAddress($toEmail);

            // Email content
            $this->mail->isHTML(false); // Set email format to plain text
            $this->mail->Subject = $subject;
            $this->mail->Body    = $message;

            // Send the email
            if ($this->mail->send()) {
                return true;
            }
            else {
                return false;
            }
            return true;
        } 
        catch (Exception $e) {
            return false;
        }
    }
}
?>