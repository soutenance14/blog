<?php

Class ContactView extends View
{
    public static function formContact($user)
    {
        $array = array(
            'title'=> 'Contact',
            'user'=> $user,
            'root'=> self::getRoot(),
        );

        return ContactView::renderView('contact/contact.twig', $array); 
    }

}