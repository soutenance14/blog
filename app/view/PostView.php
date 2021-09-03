<?php

require dirname(__DIR__) . '../../vendor/autoload.php';

Class PostView extends View
{
    public static function formPushPost($user)
    {
        $array = array(
            'title'=>'Créer article',
            'root'=>"//blog/",
            'user'=> $user,
        );
        return PostView::renderView('post/postPushForm.twig', $array);
    }

    public static function formEditPost($postEntity, $user)
    { 
        $array = array(
            'root'=>"//blog/",
            'title'=>'Modifier : '.$postEntity->getTitre(),
            'user'=> $user,
            'postEntity'=> $postEntity,
        );
        return PostView::renderView('post/postEditForm.twig', $array);
    }

    public static function get($postEntity, $listCommentsPublishedEntity, $user)
    {
        $array = array(         
            'root'=>"//blog/",
            'title'=>$postEntity->getTitre(),
            'postEntity'=> $postEntity,
            'listCommentsPublishedEntity'=> $listCommentsPublishedEntity,
            'user'=> $user,
        );
        return PostView::renderView('post/post.twig', $array);
    }

    public static function getBack($postEntity, $listCommentsPublishedEntity, $listCommentsNotPublishedEntity, $user, $id_post)
    {
        $array = array(
            'root'=>"//blog/",
            'title'=>$postEntity->getTitre(),
            'postEntity'=> $postEntity,
            'listCommentsPublishedEntity'=> $listCommentsPublishedEntity,
            'listCommentsNotPublishedEntity'=> $listCommentsNotPublishedEntity,
            'user'=> $user,
            'id_post'=> $id_post,
        );
        return PostView::renderView('post/postBack.twig', $array); 
    }
    
    public static function getNotExist($id)
    {
        return PostView::renderViewMessage('redirection ce post '.$id.' n\'existe pas.');
    }

    public static function getAll($listPostsEntity, $user)
    {
        $array = array(
            'title'=> 'Liste des articles',
            'listPostsEntity'=> $listPostsEntity,
            'user'=> $user,
        );
        return PostView::renderView('post/posts.twig', $array); 
    }

    public static function getAllBack($listPostsEntity, $user)
    {
        $array = array(
            'listPostsEntity'=> $listPostsEntity,
            'user'=> $user,
        );
        return PostView::renderView('post/postsBack.twig', $array); 
    }

    public static function getNoPostExist()
    {
        return PostView::renderViewMessageTitle('Pas de post trouvé', 'Il n\'y a pas de post pour le moment');  
    }
    
    public static function pushFail()
    {
        return PostView::renderViewMessage('Le push a échoué');  
    }
    
    public static function editFail()
    {
        return PostView::renderViewMessage('L\'edition  a échoué');  
    }
    
    public static function deleteFail()
    {
        return PostView::renderViewMessage('La suppression a échoué');  
    }
}