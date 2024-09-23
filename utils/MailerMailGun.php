<?php
# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;

class MailerMailGun {
    private $mgClient;
    private $domain;

    public function __construct()
    {
        # Instantiate the Mailgun client (v3 and above)
        $this->mgClient = Mailgun::create('a7fdedc2f4113dcb0c4cb4e4c4e78763-7a3af442-c1123646');  // Use ::create() instead of new Mailgun()
        $this->domain = "sandboxc9fa3dd00ba049a8b11031fe580f106a.mailgun.org";
    }

    public function send($recipients,$subject,$massage) {
        # If a single recipient is passed as a string, convert to an array
        if (!is_array($recipients)) {
            $recipients = [$recipients];
        }
    
        # Convert array of recipients to a comma-separated string
        $toRecipients = implode(', ', $recipients);
        # Make the call to the Mailgun API.
        $responce = $this->mgClient->messages()->send($this->domain, [
            'from'    => 'kavindahemarathna321@gmail.com',
            'to'      => $toRecipients,
            'subject' => $subject,
            'text'    => $massage
        ]);
        
        if ($responce) {
            $messageId = $responce->getId();
            $messageStatus = $responce->getMessage(); 
            
            return [
                'id' => $messageId,
                'status' => $messageStatus
            ];
        }
    }
}


?>