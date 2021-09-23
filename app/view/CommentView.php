<?php

Class CommentView extends View
{
    public static function wrongValueEditComment($user)
    {
        $array = array(
            'user'=> $user,
            'title'=> 'Oops petit problème',
            'message'=> 'Mauvaise valeur donné : 
            0 pour supprimer, 1 pour valider uniquement.',
            'root'=>self::getRoot(),
        ); 
        return CommentView::renderViewMessage($array);  
    }
}