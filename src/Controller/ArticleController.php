<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{
    /**
     * @Route("/")
     */
    public function homepage(){
        return new Response('First page created');
    }

    /**
     * @Route("/show/{slug}")
     */
    public function show($slug){
        return new Response(sprintf("The page to display slugs: %s", $slug));
    }
}