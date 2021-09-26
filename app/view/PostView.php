<?php

namespace App\View;

Class PostView extends View
{
    public static function formPushPost()
    {
        $array = array(
            'title'=>'Créer article',
        );
        return PostView::renderView('post/postPushForm.twig', $array);
    }

    public static function formEditPost($postEntity)
    { 
        $array = array(
            'title'=>'Modifier : '.$postEntity->getTitre(),
            'postEntity'=> $postEntity,
        );
        return PostView::renderView('post/postEditForm.twig', $array);
    }

    public static function get($postEntity, $listCommentsPublishedEntity)
    {
        $array = array(         
            'title'=>$postEntity->getTitre(),
            'postEntity'=> $postEntity,
            'listCommentsPublishedEntity'=> $listCommentsPublishedEntity,
        );
        return PostView::renderView('post/post.twig', $array);
    }

    public static function getBack($postEntity, $listCommentsPublishedEntity, 
    $listCommentsNotPublishedEntity,$id_post)
    {
        $array = array(
            'title'=>$postEntity->getTitre(),
            'postEntity'=> $postEntity,
            'listCommentsPublishedEntity'=> $listCommentsPublishedEntity,
            'listCommentsNotPublishedEntity'=> $listCommentsNotPublishedEntity,
            'id_post'=> $id_post,
        );
        return PostView::renderView('post/postBack.twig', $array); 
    }
    
    public static function getNotExist($id)
    {
        $array = array(
            'title'=> 'Oops petit problème',
            'message'=> 'Le post "'.$id.'" n\'existe pas.',
        ); 
        return PostView::renderViewMessage($array);
    }

    public static function getAll($listPostsEntity)
    {
        $array = array(
            'title'=> 'Liste des articles',
            'listPostsEntity'=> $listPostsEntity,
        );
        return PostView::renderView('post/posts.twig', $array); 
    }

    public static function getAllBack($listPostsEntity)
    {
        $array = array(
            'listPostsEntity'=> $listPostsEntity,
        );
        return PostView::renderView('post/postsBack.twig', $array); 
    }

    public static function getNoPostExist()
    {
        $array = array(
            'title'=> 'Pas de post trouvé',
            'message'=> 'Il n\'y a pas de post pour le moment',
        ); 
        return PostView::renderViewMessage($array);  
    }

    public static function errorMessage($error)
    {
        $message = "error";
       
        switch($error)
        {
            case "editFail":
                    $message = 'Erreur lors de la requête, les modifications,
                     n\'ont pas été enregistrés.';
                break;
            case "memberExists":
                if(isset($array["login"]))
                {
                    $message = "Le login ".$array["login"]." est déja utilisé,
                    veuillez en changer.";
                }
                break;    
            case "deleteFail":
                $message = 'La suppression a échoué';
                break;
                
            case "pushFail":
                    $message = 'Erreur lors de l\'enregistrement en base de données,
                    l\'article n\'a pas été crée.';
                break;
            case "wrongLoginForUser":
                    $message = 'Le login et l\'id ne correspondent pas.';
                break;
            
            case "editPasswordFail":
                    $message = 'La modification du mot de passe a échoué';
                break;
            
        }
        return $message;
    }
}