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
                ->setEmail(sprintf('username%d@thespacebar.com', $currentCount))
                ->setFirstname($this->faker->firstName)
            ;

            if($this->faker->boolean){
                $user->setTwitterUsername($this->faker->userName);
            }

            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'));

            return $user;
        });

        $this->createMany(3, 'admin_users', function($currentCount){
            $user = new User();

            $user
                ->setEmail(sprintf('admin%d@thespacebar.com', $currentCount))
                ->setFirstname($this->faker->firstName)
                ->setRoles(['ROLE_ADMIN'])
            ;

            if($this->faker->boolean){
                $user->setTwitterUsername($this->faker->userName);
            }

            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'));

            return $user;
        });

        $manager->flush();
    }
}
