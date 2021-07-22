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

    public static function get($postEntity, $listCommentsPublishedEntity, $user, $id_post)
    {

        try 
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('template');
        
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load('post.twig');
        
            // set template variables
            // render template
            // return $listCommentsPublishedView;
            return $template->render(array(
                'root'=>"../",
                'postEntity'=> $postEntity,
                'listCommentsPublishedEntity'=> $listCommentsPublishedEntity,
                'user'=> $user,
                'id_post'=> $id_post,
            ));
        
        } catch (Exception $e) 
        {
           return PostView::renderViewFail($e);
        }
    }

    public static function getBack($postEntity, $listCommentsPublishedEntity, $listCommentsNotPublishedEntity, $user, $id_post)
    {
        try 
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('template');
        
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load('postBack.twig');
        
            // set template variables
            // render template
            // return $listCommentsPublishedView;
            return $template->render(array(
                'root'=>"../",
                'postEntity'=> $postEntity,
                'listCommentsPublishedEntity'=> $listCommentsPublishedEntity,
                'listCommentsNotPublishedEntity'=> $listCommentsNotPublishedEntity,
                'user'=> $user,
                'id_post'=> $id_post,
            ));
        
        } catch (Exception $e) 
        {
           return PostView::renderViewFail($e);
        }
    }
    
    public static function getNotExist($id)
    {
        return 'redirection ce post '.$id.' n\'existe pas.';
    }

    public static function getAll($listPostsEntity, $user)
    {

        try 
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('template');
        
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load('posts.twig');
        
            // set template variables
            // render template
            return $template->render(array(
                'listPostsEntity'=> $listPostsEntity,
                'user'=> $user,
            ));
        
        } catch (Exception $e) 
        {
           return PostView::renderViewFail($e);
        }
    }

    public static function getAllBack($listPostsEntity, $user)
    {
        try 
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('template');
        
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load('postsBack.twig');
        
            // set template variables
            // render template
            return $template->render(array(
                'listPostsEntity'=> $listPostsEntity,
                'user'=> $user,
            ));
        
        } catch (Exception $e) 
        {
           return PostView::renderViewFail($e);
        }  
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

    public static function  renderViewFail(Exception $e)
    {
        return View::renderViewFail($e);
    }
    
}