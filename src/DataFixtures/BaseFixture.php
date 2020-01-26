<?php


namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixture extends Fixture
{
    /**@var ObjectManager*/
    private $manager;
    /**@var Generator*/
    protected $faker;

    private $referencesIndex = [];

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();

        $this->loadData($manager);
    }

    abstract protected function loadData(ObjectManager $manager);

    protected function createMany(string $className, int $count, callable $factory){
        for($i = 0; $i < $count; $i++){
            $entity = new $className();
            $factory($entity, $i);
            $this->manager->persist($entity);
            // store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference($className . '_' . $i, $entity);
        }
    }

    protected function getRandomReference(string $classname){
        if(!isset($this->referencesIndex[$classname])){
            $this->referencesIndex[$classname] = [];

            foreach($this->referenceRepository->getReferences() as $key => $ref){
                if(strpos($key, $classname.'_') === 0){
                    $this->referencesIndex[$classname][] = $key;
                }
            }

            if(empty($this->referencesIndex[$classname])){
                throw new \Exception(sprintf("Cannot find any reference for class '%s'.", $classname));
            }
        }

        $randomReference = $this->faker->randomElement($this->referencesIndex[$classname]);

        return $this->getReference($randomReference);
    }

    public function getRandomReferences(string $classname, int $count){
        $references = [];

        while (count($references) < $count){
            $references[] = $this->getRandomReference($classname);
        }

        return $references;
    }
}