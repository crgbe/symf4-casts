<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
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
        $comments = [
            'You are so fast when coding now !!!',
            'Remember at your beginning, you did not even knew what to write',
            'hhhh!!! You little kind boy :D'
        ];

        return $this->render('article/show.html.twig', [
            'title' => ucfirst(str_replace('-', ' ', $slug)),
            'comments' => $comments,
        ]);
    }
}