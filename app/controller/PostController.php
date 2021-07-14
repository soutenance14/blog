<?php

require  dirname(__DIR__) . '../model/PostManager.php';
Class PostController
{
    public static function get(String $id)
    {
        
        $post = PostManager::get($id);
        if($post != null)
        {
            echo 'récupération de post '. $post['id'];
        }
        else
        {
            echo 'redirection ce post n\'existe pas.';
        }
    }
}