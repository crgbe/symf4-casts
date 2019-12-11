<?php


namespace App\Controller;


use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ArticleController extends AbstractController
{
    /**
     * @Route("/phpinfo")
     */
    public function phpinfo(){
        echo phpinfo();
        return new Response("These are PHP infos");
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(){
        $name = "This is the homepage";

        return $this->render('article/homepage.html.twig', [
            'title' => $name,
        ]);
    }

    /**
     * @Route("/show/{slug}")
     */
    public function show($slug){
        $comments = [
            'You are so fast when coding now !!!',
            'Remember at your beginning, you did not even know what to write',
            'hhhh!!! You little kind boy :D'
        ];

        return $this->render('article/show.html.twig', [
            'title' => ucfirst(str_replace('-', ' ', $slug)),
            'slug' => $slug,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleHeart($slug, LoggerInterface $logger){
        $logger->info("The article is being loved");

        return $this->json([
            'hearts' => rand(5, 100),
        ]);
    }
}