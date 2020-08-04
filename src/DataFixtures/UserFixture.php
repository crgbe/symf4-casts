<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function($currentCount){
            $user = new User();

            $user
                ->setEmail(sprintf('username%d@spacebar.com', $currentCount))
                ->setFirstname($this->faker->firstName)
            ;

            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'));

            return $user;
        });

        $manager->flush();
    }
}
