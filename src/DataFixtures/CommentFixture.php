<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixture extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Comment::class, 100, function(Comment $comment, $count){
            $comment->setAuthorName($this->faker->name)
                ->setContent($this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true))
                ->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'))
                ->setArticle($this->getRandomReferences(Article::class))
            ;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ArticleFixtures::class];
    }
}
