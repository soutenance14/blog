<?php

require dirname(__DIR__) . '../../vendor/autoload.php';

Class PostView extends View
{
    public static function formPushPost($user)
    {
        $array = array(
            'title'=>'Créer article',
            'user'=> $user,
            'root'=>self::getRoot(),
        );
        return PostView::renderView('post/postPushForm.twig', $array);
    }

    public static function formEditPost($postEntity, $user)
    { 
        $array = array(
            'title'=>'Modifier : '.$postEntity->getTitre(),
            'user'=> $user,
            'postEntity'=> $postEntity,
            'root'=>self::getRoot(),
        );
        return PostView::renderView('post/postEditForm.twig', $array);
    }

    public static function get($postEntity, $listCommentsPublishedEntity, $user)
    {
        $array = array(         
            'title'=>$postEntity->getTitre(),
            'postEntity'=> $postEntity,
            'listCommentsPublishedEntity'=> $listCommentsPublishedEntity,
            'user'=> $user,
            'root'=>self::getRoot(),
        );
        return PostView::renderView('post/post.twig', $array);
    }

    public static function getBack($postEntity, $listCommentsPublishedEntity, $listCommentsNotPublishedEntity, $user, $id_post)
    {
        $array = array(
            'title'=>$postEntity->getTitre(),
            'postEntity'=> $postEntity,
            'listCommentsPublishedEntity'=> $listCommentsPublishedEntity,
            'listCommentsNotPublishedEntity'=> $listCommentsNotPublishedEntity,
            'user'=> $user,
            'id_post'=> $id_post,
            'root'=>self::getRoot(),
        );
        return PostView::renderView('post/postBack.twig', $array); 
    }
    
    public static function getNotExist($id, $user)
    {
        $array = array(
            'user'=> $user,
            'title'=> 'Oops petit problème',
            'message'=> 'Le post "'.$id.'" n\'existe pas.',
            'root'=>self::getRoot(),
        ); 
        return PostView::renderViewMessage($array);
    }

    public static function getAll($listPostsEntity, $user)
    {
        $array = array(
            'title'=> 'Liste des articles',
            'listPostsEntity'=> $listPostsEntity,
            'user'=> $user,
            'root'=>self::getRoot(),
        );
        return PostView::renderView('post/posts.twig', $array); 
    }

    public static function getAllBack($listPostsEntity, $user)
    {
        $array = array(
            'listPostsEntity'=> $listPostsEntity,
            'user'=> $user,
            'root'=>self::getRoot(),
        );
        return PostView::renderView('post/postsBack.twig', $array); 
    }

    public static function getNoPostExist($user)
    {
        $array = array(
            'user'=> $user,
            'title'=> 'Pas de post trouvé',
            'message'=> 'Il n\'y a pas de post pour le moment',
            'root'=>self::getRoot(),
        ); 
        return PostView::renderViewMessage($array);  
    }
    
    public static function pushFail($user)
    {
        $array = array(
            'user'=> $user,
            'title'=> 'Oops petit problème',
            'message'=> 'Le push a échoué',
            'root'=>self::getRoot(),
        ); 
        return PostView::renderViewMessage($array);  
    }
    
    public static function editFail($user)
    {
        $array = array(
            'user'=> $user,
            'title'=> 'Oops petit problème',
            'message'=> 'L\'edition  a échoué',
            'root'=>self::getRoot(),
        ); 
        return PostView::renderViewMessage($array);  
    }
    
    public static function deleteFail($user)
    {
        $array = array(
            'user'=> $user,
            'title'=> 'Oops petit problème',
            'message'=> 'La suppression a échoué',
            'root'=>self::getRoot(),
        ); 
        return PostView::renderViewMessage($array);  
    }
}