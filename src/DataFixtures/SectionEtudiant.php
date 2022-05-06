<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use App\Entity\PFE;
use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SectionEtudiant extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i <= 10; $i++) {
            $etudiant = new Etudiant();
            $etudiant->setNom($faker->name);
            $etudiant->setPrenom($faker->firstName);
            $manager->persist($etudiant);
            for ($i = 0; $i <= 10; $i++) {
                $etudiant = new Etudiant();
                $section=new Section();
                $etudiant->setNom($faker->name);
                $etudiant->setPrenom($faker->firstName);
//                $etudiant->setSection($section);
                $manager->persist($etudiant);

            }
            for ($i = 0; $i <= 19; $i++) {
                $Section = new Section();
                $Section->setDesignation($faker->title);
                $manager->persist($Section);
            }

            $manager->flush();
        }
    }
}