<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Provider\Lorem as FakerLorem;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Génère 50 nouveaux tags en base de données
        $faker = FakerFactory::create();
        for ($i = 0; $i < 50; $i++) {
            $tag = new Tag();
            $tag->setLabel(FakerLorem::word());
            $manager->persist($tag);
        }

        $manager->flush();
    }
}