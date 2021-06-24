<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Provider\Lorem as FakerLorem;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Génère 100 nouveaux auteurs en base de données
        $faker = FakerFactory::create();
        for ($i = 0; $i < 100; $i++) {
            $author = new Author();
            $author->setName($faker->name);
            $author->setBirthDate(new \DateTime('@' . mt_rand(0 ,time())));
            $manager->persist($author);
        }

        $manager->flush();
    }
}