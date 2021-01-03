<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {

        for($i = 1; $i <= 1000; $i++) {
            $episode = new Episode();
            $faker = Faker\Factory::create('fr_FR');
            $episode ->setNumber($faker->randomDigitNotNull);
            $episode ->setTitle($faker->sentence);
            $slugTitle = $this->slugify->generate($episode->getTitle());
            $episode->setSlug($slugTitle);
            $episode ->setSynopsis($faker->text);
            $episode ->setSeason($this->getReference('season_' . rand(1, 100)));
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
