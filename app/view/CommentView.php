<?php
namespace App\View;

Class CommentView extends View
{
    public static function wrongValueEditComment()
    {
        $array = array(
            'title'=> 'Oops petit problème',
            'message'=> 'Mauvaise valeur donné : 
            0 pour supprimer, 1 pour valider uniquement.',
        ); 
        return CommentView::renderViewMessage($array);  
    }
}