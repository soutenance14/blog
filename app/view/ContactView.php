<?php

Class ContactView
{
    public static function formContact()
    {
        return "Contact
        <form action ='sendMessage' method ='post'><input name='nom'><input name='mail'><input name='contenu'><input type='submit' name ='submit' value='ok'>
        </form>";
    } 
}