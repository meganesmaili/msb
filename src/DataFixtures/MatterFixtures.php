<?php

namespace App\DataFixtures;

use App\Entity\Matter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MatterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nom = ["Coton","Acrylique","Polyester","Coton bio d'Egypte"];

        for ($i=0; $i < 4; $i++) { 
            
            $matter = New Matter();

            $matter->setName($nom[$i]);

            $this->addReference("matter_$i", $matter);

            $manager->persist($matter);
            
        }

        $manager->flush();
    }
}
