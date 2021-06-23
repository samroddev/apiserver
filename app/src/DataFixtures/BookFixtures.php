<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Provider\Lorem as FakerLorem;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Génère 1000 nouveaux livres en base de données
        $faker = FakerFactory::create();
        for ($i = 0; $i < 1000; $i++) {
            $book = new Book();
            $book->setTitle(FakerLorem::sentence($nbWords = 6));
            $book->setResume(FakerLorem::text(512));
            $book->setPagesCount(mt_rand(10, 1000));
            $book->setInSell(mt_rand(0, 10) > 2);
            $book->setIsbn($faker->isbn13);
            $book->setPublishedAt(new \DateTime('@' . mt_rand(0, time())));
            $manager->persist($book);
        }

        $manager->flush();
    }
}