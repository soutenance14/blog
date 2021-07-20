<?php

require dirname(__DIR__) . '../../vendor/autoload.php';
use \Mailjet\Resources;

 Class ContactController
{
    //FORM
    public static function formContact()
    {
        echo ContactView::formContact();
    }
    
    public static function sendMessage($nom, $mail, $contenu)
    {
        try
        {

            $day = date('d');
            $month = date('m');
            $year = date('Y');
            
            $date = $day. " ". $month." ".$year;
            // Create the Transport
            $transport = (new Swift_SmtpTransport('in-v3.mailjet.com', 587))
            ->setUsername('9a12076fa51e88fe69d977d2312ef96d')
            ->setPassword('b51c774ab5a29ab8e0d1f4fc2e7c9fbc')
            ;
            
            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);
            
            // Create a message
            
            $subject = $nom. ' vous a envoyé un message le '.$date;
            $message = 
            '<html>
            <h1>Vous avez reçu un nouveau message provenant du formulaire de contact:</h1>
            <hr>
            <h2>'.$nom.'</h2>
            <h3>'.$mail.'</h3>
            <h3>Le '.$date.'</h3>
            <hr>
            <p>
            CONTENU DU MESSAGE:
            '.$contenu.'
            </p>
            </html>';
            $message = (new Swift_Message($subject))
            ->setFrom(['soutenance20@gmail.com' => 'Admin Contact 20'])
            ->setTo(['soutenance14@gmail.com' => 'Admin Contact'])
            // ->setTo(['soutenance14@gmail.com', 'soutenance13@gmail.com' => 'Admin Contact'])
            ->setBody($message, 'text/html')
            ;
            
            // Send the message
            $result = $mailer->send($message);
            echo 'header/location/home/messageSuccess.';
        }
        catch (Exception $e)
        {
            echo 'header/location/formContact/messageFailed';
        }
    }
}