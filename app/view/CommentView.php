<?php

Class CommentView
{
    
    public static function formPushPost($user)
    {
        return "formPushPost
        <form action ='pushPost' method ='post'><input name='auteur'><input name='titre'><input name='chapo'><input name='contenu'>
        <input type='submit' name ='submit' value='ok'>
        <br> <input name ='token' value='".$user->getToken()."'>
        </form>";
    }

    public static function formEditPost($commentEntity, $user)
    {
        return "formEditPost
        <br>created_at :" . $commentEntity->getCreatedAt()
        ."<form action ='../../editPost' method ='post'>
                <input name='id' readonly value='".$commentEntity->getId()."'>
                <input name='auteur' value='".$commentEntity->getAuteur()."'>
                <input name='titre' value='".$commentEntity->getTitre()."'>
                <input name='chapo' value='".$commentEntity->getChapo()."'>
                <input name='contenu' value='".$commentEntity->getContenu()."'>
                <input type='submit' name ='submit' value='ok'>
                <br> <input name ='token' value='".$user->getToken()."'>
                </form>";
    }

    // public static function get($commentEntity, $listCommentsEntity)
    // {
    //     return 'Post ' . var_dump($commentEntity).
    //      '<br>published comment: ' . var_dump ($listCommentsEntity);
    // }

    // public static function getNotExist($id)
    // {
    //     return 'redirection ce post '.$id.' n\'existe pas.';
    // }

    // public static function getBack($commentEntity, $listCommentsPublishedEntity, $listCommentsNotPublishedEntity)
    // {
    //     return 'Post' . var_dump($commentEntity).
    //     '<br>published' . var_dump ($listCommentsPublishedEntity).
    //     '<br>not published' . var_dump ($listCommentsNotPublishedEntity);
    // }

    // public static function getAll($listCommentsEntity)
    // {
    //     $view = '<h1>Back : touts les comments</h1>';
    //     foreach($listCommentsEntity as $commentEntity)
    //     {
    //         $view.= '<div>'
    //                     .'<h4> Par '.$commentEntity->getLogin().' le '.$commentEntity->getCreatedAt().'</h4>'
    //                     .'<h4>Contenu :'.$commentEntity->getContenu().'</h4>'
    //                 .'</div><hr>';
    //     }
    //     return $view;  
    // }

    public static function getAll($listCommentsEntity, $LabelForComments, $user)
    {
        $view = '<h1>'.$LabelForComments.'</h1>';
        foreach($listCommentsEntity as $commentEntity)
        {
            $linkCommentManageView = "";
            if($user->getPermission() == ADMIN)
            {
                $linkCommentManageView  = CommentView::linkCommentManageBack($commentEntity, $user);
            }
            else
            {
                $linkCommentManageView  = CommentView::linkCommentManage($commentEntity, $user);
            }

            $view.= '<div>'
                        .'<h4> Par '.$commentEntity->getLogin().' le '.$commentEntity->getCreatedAt().'</h4>'
                        .'<h4>Contenu :'.$commentEntity->getContenu().'</h4>'
                        .$linkCommentManageView
                    .'</div><hr>';
        }
        return $view;  
    }

    //util getAllBack

    public static function linkCommentManage($commentEntity, $user)
    {
        $linkCommentManage = "";
        if($commentEntity->getIdMembre() === $user->getId())
        {
            $linkCommentManage = '<h4><a href="../deleteComment/'.$commentEntity->getId().'/'.$user->getToken().'">Supprimer Commentaire</a></h4>';
        }
        return $linkCommentManage;
    }
    public static function linkCommentManageBack($commentEntity, $user)
    {
        $linkCommentManage = "";
        if($commentEntity->getIdMembre() === $user->getId())
        {
            $linkCommentManage = '<h4><a href="../setPublishedComment/'.$commentEntity->getId().'/0/'.$user->getToken().'">Ne pas publié le commentaire.</a></h4>'
            .'<h4><a href="../setPublishedComment/'.$commentEntity->getId().'/1/'.$user->getToken().'">Publié le commentaire.</a></h4>'
            .'<h4><a href="../deleteComment/'.$commentEntity->getId().'/'.$user->getToken().'">Supprimer Commentaire</a></h4>';
        }
        return $linkCommentManage;
    }


    public static function getNoCommentExist($listCommentsEntity)
    {
        return 'Il n\'y a pas de Commentaire pour le moment';  
    }
    
    public static function pushFail()
    {
        return 'Le push a échoué';  
    }
    
    public static function editFail()
    {
        return 'L\'edition  a échoué';  
    }
    
    public static function deleteFail()
    {
        return 'La suppression a échoué';  
    }
    
}