<?php

Class ContactView extends View
{
    public static function formContact($user)
    {
        $array = array(
            'title'=> 'Contact',
            'user'=> $user,
        );

        return ContactView::renderView('contact/contact.twig', $array); 
    }

}