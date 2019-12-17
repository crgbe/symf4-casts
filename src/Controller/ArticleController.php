<?php


namespace App\Controller;


use App\Service\MarkdownHelper;
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
    public function homepage(){
        $name = "This is the homepage";

        return $this->render('article/homepage.html.twig', [
            'title' => $name,
        ]);
    }

    /**
     * @Route("/show/{slug}")
     */
    public function show($slug, MarkdownHelper $markdownHelper, bool $isDebug){
        $articleContent = <<<EOF
Spicy jalapeno **bacon ipsum dolor** amet veniam shank in dolore. Ham hock nisi landjaeger cow,
lorem proident [beef ribs](https://www.google.com) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
turkey shank eu pork belly meatball non cupim.
Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
occaecat lorem meatball prosciutto quis strip steak.
Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
strip steak pork belly aliquip **capicola officia**. Labore deserunt esse chicken lorem shoulder tail consectetur
cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
fugiat
EOF;
        $articleContent = $markdownHelper->parse($articleContent);

        $comments = [
            'You are so fast when coding now !!!',
            'Remember at your beginning, you did not even know what to write',
            'hhhh!!! You little kind boy :D'
        ];

        return $this->render('article/show.html.twig', [
            'title' => ucfirst(str_replace('-', ' ', $slug)),
            'slug' => $slug,
            'articleContent' => $articleContent,
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