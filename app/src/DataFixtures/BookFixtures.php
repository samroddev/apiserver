<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Provider\Lorem as FakerLorem;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Récupère une liste d'objets associés
        $tags = $manager->getRepository(Tag::class)->findAll();
        $authors = $manager->getRepository(Author::class)->findAll();
        // Génère 1000 nouveaux livres en base de données
        $faker = FakerFactory::create();
        for ($i = 0; $i < 1000; $i++) {
            $book = new Book();
            $book->setTitle(FakerLorem::sentence($nbWords = 6));
            $book->setResume(FakerLorem::text(512));
            $book->setPagesCount(rand(10, 1000));
            $book->setInSell(rand(0, 10) > 2);
            $book->setIsbn($faker->isbn13);
            $book->setPublishedAt(new \DateTime('@' . rand(0, time())));
            $author = $authors[rand(0, count($authors) - 1)];
            $book->setAuthor($author);
            for ($j = 0; $j < rand(0, 5); $j++) {
                $tag = $tags[rand(0, count($tags) - 1)];
                $book->addTag($tag);
            }
            $manager->persist($book);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AuthorFixtures::class,
            TagFixtures::class,
        ];
    }
}