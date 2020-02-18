<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixture implements DependentFixtureInterface
{
    private static $articleTitles = [
        'One question: How to be better PHP/Symfony developper ?',
        'Secret trick: How to code great in PHP/Symfony ?',
        'Conception: The best way to create an incredible app',
        'Angular !!!: The big controversal Symfony competitor',
    ];

    private static $articleAuthors = [
        'Mike Ferengi',
        'Arthur Ferrer',
        'Hafsa Ljioui',
    ];

    private static $articleImages = [
        'coding_game.jpeg',
        'symfony.png',
        'mysql_developper.png',
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, Article::class, function(){
            $article = new Article();

            $article->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setContent(<<<EOF
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
EOF);
            //This will publish most articles
            if($this->faker->boolean(70)){
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $article->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setHeartCount($this->faker->numberBetween(5, 100))
                ->setImageFilename($this->faker->randomElement(self::$articleImages))
            ;

            $tagList = $this->getRandomReferences(Tag::class, $this->faker->numberBetween(0, 5));

            /**@var $tagList Tag[]*/
            foreach($tagList as $tag){
                $article->addTag($tag);
            }

            return $article;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [TagFixture::class];
    }
}
