<?php


namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function homepage(ArticleRepository $articleRepository){
//        $articles = $em->getRepository(Article::class)->findBy([], ['publishedAt' => 'DESC']);
        $articles = $articleRepository->findAllPublishedOrderedByNewest();
        $name = "This is the homepage";

        return $this->render('article/homepage.html.twig', [
            'title' => $name,
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/show/{slug}", name="article_show")
     */
    public function show(Article $article, ArticleRepository $articleRepository){
//        if(!$article){
//            throw $this->createNotFoundException(sprintf("Article with slug: '%s' does not exist", $slug));
//        }

        $comments = [
            'You are so fast when coding now !!!',
            'Remember at your beginning, you did not even know what to write',
            'hhhh!!! You little kind boy :D'
        ];

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em){
        if(!$article){
            throw $this->createNotFoundException("There is no article with that slug available in the database.");
        }

        $article->incrementHeartCount();
        $em->flush();

        $logger->info("The article is being loved");

        return $this->json([
            'hearts' => $article->getHeartCount(),
        ]);
    }
}