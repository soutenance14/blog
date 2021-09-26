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

    public static function commentNotFound()
    {
        $array = array(
            'title'=> 'Oops petit problème',
            'message'=> "Ce commentaire n'a pas été trouvé",
        );
        return CommentView::renderViewMessage($array);  
    }
    
    public static function commentDeleteFail()
    {
        $array = array(
            'title'=> 'Oops petit problème',
            'message'=> "La suppréssion à échoué, 
            une érreur s'est produit en base de données",
        );
        return CommentView::renderViewMessage($array);  
    }




}