<?php

Class CommentView extends View
{
    public static function errorMessage($user, $message)
    {
        $array = array(
            'user'=> $user,
            'title'=> 'Oops petit problème',
            'message'=> $message,
            'root'=>self::getRoot(),
        ); 
        return CommentView::renderViewMessage($array);  
    }
}