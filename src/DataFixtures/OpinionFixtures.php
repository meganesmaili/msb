<?php

namespace App\DataFixtures;

use App\Entity\Opinion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OpinionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 10; $i++) { 
           
            $opinions = New Opinion;
            $opinions->setAvis("Avis_$i");
            $opinions->setScore(3);

            $manager->persist($opinions);
        }

        $manager->flush();
    }
}
