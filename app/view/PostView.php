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

    public static function get($postEntity, $listCommentsPublishedEntity, $user)
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
            ));
        
        } catch (Exception $e) 
        {
           echo PostView::renderViewFail($e);
        }
    }

    public static function getBack($postEntity, $listCommentsPublishedEntity, $listCommentsNotPublishedEntity)
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
            ));
        
        } catch (Exception $e) 
        {
           echo PostView::renderViewFail($e);
        }
    }
    
    public static function getNotExist($id)
    {
        return 'redirection ce post '.$id.' n\'existe pas.';
    }

    public static function getAll($listPostsEntity)
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
            echo $template->render(array(
                'listPostsEntity'=> $listPostsEntity,
            ));
        
        } catch (Exception $e) 
        {
           echo PostView::renderViewFail($e);
        }
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

    public static function  renderViewFail(Exception $e)
    {
        return View::renderViewFail($e);
    }
    
}