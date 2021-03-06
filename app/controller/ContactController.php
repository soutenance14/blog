<?php

namespace App\Controller;

use App\View\ContactView;
use Exception;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Component\HttpFoundation\Request;

Class ContactController
{
    //FORM
    public static function formContact()
    {
        return(ContactView::formContact());
    }
    
    public static function sendMessage(Request $request)
    {
        if( Controller::checkForm($request, [
            "nom",
            "mail",
            "contenu"]))
        {
            $nom = $request->get("nom");
            $mail = $request->get("mail");
            $contenu = $request->get("contenu");
            require dirname(__DIR__).'../../app/config/configMailLocal.php';
            // for getting all config email variables
            try
            {
                $day = date('d');
                $month = date('m');
                $year = date('Y');
                
                $date = $day. " ". $month." ".$year;
                // Create the Transport
                $transport = (new Swift_SmtpTransport(SERVER, PORT))
                ->setUsername(USER)
                ->setPassword(PASS)
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
                ->setFrom([EMAIL => NAME_EMAIL])
                ->setTo([EMAIL => NAME_EMAIL])
                // ->setTo(['example1@gmail.com', 'example2@gmail.com' => 'Name email']) multiple
                ->setBody($message, 'text/html')
                ;
                
                // Send the message
                $mailer->send($message);
                return(ContactView::success());
            }
            catch (Exception $e)
            {
                //message asynchrone
                return(ContactView::renderViewException(
                    $e, "Oops une erreur est arrivé", "mailError-bg",
                    'Echec lors de l\'envoie, le message n\a pas été envoyé. '.$e->getMessage()));
                }
            }
        else
        {
            return ContactView::errorForm();
        }
    }
}