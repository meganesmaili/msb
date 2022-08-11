<?php

namespace App\DataFixtures;

use App\Entity\Products;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProductsFixtures extends Fixture implements DependentFixtureInterface
{
    

    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');


        for ($i=0; $i < 15; $i++) { 

            $date = new DateTimeImmutable();
            $randDate = $date->modify('-'. rand(1, 600) .' days');

            $products = New Products();
            $products ->setName($faker->word);
            $products ->setDescription($faker->word);
            $products ->setPicture($faker->word);
            $products->setUpdatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years')));
            

            $products->setCategory($this->getReference("category_". rand(0,3)));
            $products->setMatter($this->getReference('matter_'. rand(0,3)));
            

            $manager->persist($products);

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}
