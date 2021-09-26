<?php
namespace App\View;

Class ContactView extends View
{
    public static function formContact()
    {
        $array = array(
            'title'=> 'Contact');

        return ContactView::renderView('contact/contact.twig', $array); 
    }

}