<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function($currentCount){
            $user = new User();

            $user
                ->setEmail(sprintf('username%d@spacebar.com', $currentCount))
                ->setFirstname($this->faker->firstName)
            ;

            return $user;
        });

        $manager->flush();
    }
}
