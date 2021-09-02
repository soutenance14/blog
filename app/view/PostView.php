<?php

require dirname(__DIR__) . '../../vendor/autoload.php';

Class PostView extends View
{
    public static function home()
    {
        return 'home';
    }

    public static function formPushPost($user)
    {
        try 
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('../app/template');
        
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load('post/postPushForm.twig');
        
            // set template variables
            // render template
            // return $listCommentsPublishedView;
            return $template->render(array(
                //A MODIFIER ROOT DANS PARAM
                'title'=>'Créer article',
                'root'=>"../",
                'user'=> $user,
            ));
        
        } catch (Exception $e) 
        {
           return PostView::renderViewFail($e);
        }
    }

    public static function formEditPost($postEntity, $user)
    {
        try 
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('../app/template');
        
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load('post/postEditForm.twig');
        
            // set template variables
            // render template
            // return $listCommentsPublishedView;
            return $template->render(array(
                //A MODIFIER ROOT DANS PARAM
                'root'=>"../",
                'title'=>'Modifie : '.$postEntity->getTitre(),
                'user'=> $user,
                'postEntity'=> $postEntity,
            ));
        
        } catch (Exception $e) 
        {
            return PostView::renderViewFail($e);
        }
    }

    public static function get($postEntity, $listCommentsPublishedEntity, $user, $id_post)
    {
        $array = array(
            //A MODIFIER ROOT DANS PARAM
            'root'=>"../",
            'title'=>$postEntity->getTitre(),
            'postEntity'=> $postEntity,
            'listCommentsPublishedEntity'=> $listCommentsPublishedEntity,
            'user'=> $user,
            'id_post'=> $id_post,
        );
        return PostView::renderView('post/post.twig', $array);
    }

    public static function getBack($postEntity, $listCommentsPublishedEntity, $listCommentsNotPublishedEntity, $user, $id_post)
    {
        $array = array(
            'root'=>"../",
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
        return 'redirection ce post '.$id.' n\'existe pas.';
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