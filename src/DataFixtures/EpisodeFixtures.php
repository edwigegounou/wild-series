<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for($i = 1; $i < 50; $i++) {
            $episode = new Episode();
            $faker = Faker\Factory::create('fr_FR');
            $episode ->setNumber($faker->randomDigitNotNull);
            $episode ->setTitle($faker->sentence);
            $episode ->setSynopsis($faker->text);
            $episode ->setSeason($this->getReference('season_' . rand(1, 10)));
            $manager ->persist($episode);
            $this ->addReference('episode_' . $i, $episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}
