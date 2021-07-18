<?php

Class PostView
{
    public static function home()
    {
        return 'home';
    }

    public static function formPushPost($user)
    {
        return "formPushPost
        <form action ='pushPost' method ='post'><input name='auteur'><input name='titre'><input name='chapo'><input name='contenu'>
        <input type='submit' name ='submit' value='ok'>
        <br> <input name ='token' value='".$user->getToken()."'>
        </form>";
    }

    public static function formEditPost($postEntity, $user)
    {
        return "formEditPost
        <br>created_at :" . $postEntity->getCreatedAt()
        ."<form action ='../../editPost' method ='post'>
                <input name='id' readonly value='".$postEntity->getId()."'>
                <input name='auteur' value='".$postEntity->getAuteur()."'>
                <input name='titre' value='".$postEntity->getTitre()."'>
                <input name='chapo' value='".$postEntity->getChapo()."'>
                <input name='contenu' value='".$postEntity->getContenu()."'>
                <input type='submit' name ='submit' value='ok'>
                <br> <input name ='token' value='".$user->getToken()."'>
                </form>";
    }

    public static function get($postEntity, $listCommentsEntity)
    {
        return 'Post ' . var_dump($postEntity).
         '<br>published comment: ' . var_dump ($listCommentsEntity);
    }

    public static function getNotExist($id)
    {
        return 'redirection ce post '.$id.' n\'existe pas.';
    }

    public static function getBack($postEntity, $listCommentsPublishedView, $listCommentsNotPublishedView)
    {
        return 
        '<h4> Par '.$postEntity->getAuteur().' le '.$postEntity->getCreatedAt().'</h4>'
        .'<h3>Titre :'.$postEntity->getTitre().'</h3>'
        .'<h4>Chapo :'.$postEntity->getChapo().'</h4>'
        .'<h4>Contenu :'.$postEntity->getContenu().'</h4>'
        .$listCommentsPublishedView. $listCommentsNotPublishedView;
    }

    public static function getAll($listPostsEntity)
    {
        $view = '<h1>Back : touts les posts</h1>';
        foreach($listPostsEntity as $postEntity)
        {
            $view.= '<div>'
                        .'<h4> Par '.$postEntity->getAuteur().' le '.$postEntity->getCreatedAt().'</h4>'
                        .'<h3>Titre :'.$postEntity->getTitre().'</h3>'
                        .'<h4>Chapo :'.$postEntity->getChapo().'</h4>'
                        .'<h4><a href="post/'.$postEntity->getId().'">Voir Article</a></h4>'
                    .'</div><hr>';
        }
        return $view;  
    }

    public static function getAllBack($listPostsEntity, $token)
    {
        $view = '<h1>Back : touts les posts</h1>';
        foreach($listPostsEntity as $postEntity)
        {
            $view.= '<div>'
                        .'<h4> Par '.$postEntity->getAuteur().' le '.$postEntity->getCreatedAt().'</h4>'
                        .'<h3>Titre :'.$postEntity->getTitre().'</h3>'
                        .'<h4>Chapo :'.$postEntity->getChapo().'</h4>'
                        .'<h4><a href="post/'.$postEntity->getId().'">Voir Article</a></h4>'
                        .'<h4><a href="formEditPost/'.$postEntity->getId().'/'.$token.'">Modifier l\'article.</a></h4>'
                        .'<h4><a href="deletePost/'.$postEntity->getId().'/'.$token.'">Supprimer Article</a></h4>'
                        
                    .'</div><hr>';
        }
        return $view;  
    }

    public static function getNoPostExist($listPostsEntity)
    {
        return 'Il n\'y a pas de post pour le moment';  
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