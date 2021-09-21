<?php

Class CommentView extends View
{
    // public static function linkCommentManage($commentEntity, $user)
    // {
    //     $linkCommentManage = "";
    //     if($commentEntity->getIdMembre() === $user->getId())
    //     {
    //         $linkCommentManage = '<h4><a href="../deleteComment/'.$commentEntity->getId().'/'.$user->getToken().'">Supprimer Commentaire</a></h4>';
    //     }
    //     return $linkCommentManage;
    // }
    // public static function linkCommentManageBack($commentEntity, $user)
    // {
    //     $linkCommentManage = "";
    //     if($commentEntity->getIdMembre() === $user->getId())
    //     {
    //         $linkCommentManage = '<h4><a href="../setPublishedComment/'.$commentEntity->getId().'/0/'.$user->getToken().'">Ne pas publié le commentaire.</a></h4>'
    //         .'<h4><a href="../setPublishedComment/'.$commentEntity->getId().'/1/'.$user->getToken().'">Publié le commentaire.</a></h4>'
    //         .'<h4><a href="../deleteComment/'.$commentEntity->getId().'/'.$user->getToken().'">Supprimer Commentaire</a></h4>';
    //     }
    //     return $linkCommentManage;
    // }


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

    // public static function getNoCommentExist($user)
    // {
    //     $array = array(
    //         'user'=> $user,
    //         'title'=> 'Oops petit problème',
    //         'message'=> 'Il n\'y a pas de Commentaire pour le moment',
    //         'root'=>"//blog/",
    //     ); 
    //     return CommentView::renderViewMessage($array);  
    // }
    
    // public static function getNotExist($id, $user)
    // {
    //     $array = array(
    //         'user'=> $user,
    //         'title'=> 'Oops petit problème',
    //         'message'=> 'Le commentaire '.$id.' n\'existe pas',
    //         'root'=>"//blog/",
    //     ); 
    //     return CommentView::renderViewMessage($array);
    // }
    
    // public static function pushFail($user)
    // {
    //     $array = array(
    //         'user'=> $user,
    //         'title'=> 'Oops petit problème',
    //         'message'=> 'Le push a échoué',
    //         'root'=>"//blog/",
    //     ); 
    //     return CommentView::renderViewMessage($array);  
    // }
    
    // public static function editFail($user)
    // {
    //     $array = array(
    //         'user'=> $user,
    //         'title'=> 'Oops petit problème',
    //         'message'=> 'L\'edition  a échoué',
    //         'root'=>"//blog/",
    //     ); 
    //     return CommentView::renderViewMessage($array);  
    // }
    
    // public static function deleteFail($user)
    // {
    //     $array = array(
    //         'user'=> $user,
    //         'title'=> 'Oops petit problème',
    //         'message'=> 'La suppression a échoué',
    //         'root'=>"//blog/",
    //     ); 
    //     return CommentView::renderViewMessage($array);  
    // }
    
}