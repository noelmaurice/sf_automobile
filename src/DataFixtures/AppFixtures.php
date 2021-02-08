<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $marque1 = new Marque();
        $marque1->setLibelle("Yotota");
        $manager->persist($marque1);

        $marque2 = new Marque();
        $marque2->setLibelle("Jeupo");
        $manager->persist($marque2);

        $modele1 = new Modele();
        $modele1->setLibelle("Rayis")
            ->setImage("modele". rand(3, 9) . ".jpg")
            ->setPrixMoyen(rand(70000, 180000))
            ->setMarque($marque1);
        $manager->persist($modele1);
        $modele2 = new Modele();
        $modele2->setLibelle("Yraus")
            ->setImage("modele". rand(3, 9) . ".jpg")
            ->setPrixMoyen(rand(70000, 180000))
            ->setMarque($marque1);
        $manager->persist($modele2);
        $modele3 = new Modele();
        $modele3->setLibelle("007")
            ->setImage("modele". rand(3, 9) . ".jpg")
            ->setPrixMoyen(rand(70000, 180000))
            ->setMarque($marque1);
        $manager->persist($modele3);
        $modele4 = new Modele();
        $modele4->setLibelle("008")
            ->setImage("modele". rand(3, 9) . ".jpg")
            ->setPrixMoyen(rand(70000, 180000))
            ->setMarque($marque1);
        $manager->persist($modele4);

        $modele5 = new Modele();
        $modele5->setLibelle("009")
            ->setImage("modele". rand(3, 9) . ".jpg")
            ->setPrixMoyen(rand(70000, 180000))
            ->setMarque($marque1);
        $manager->persist($modele5);

        $modeles = [
            $modele1,
            $modele2,
            $modele3,
            $modele4,
            $modele5
        ];

        $faker = Factory::create('fr_FR');

        foreach($modeles as $m)
        {
            $rand = rand(8, 14);

            for($i=1; $i <= $rand; $i++)
            {
                $voiture = new Voiture();
                //XX1234XX
                $voiture->setImmatriculation($faker->regexify("[A-Z]{2}-[0-9]{3,4}-[A-Z]{2}"))
                    ->setNbPortes($faker->randomElement($array = array(3,5)))
                    ->setAnnee($faker->numberBetween($min=1990, $max=2019))
                    ->setModele($m)
                    ->setImage("modele". rand(3, 9) . ".jpg")
                    ->setPrix(rand(70000, 180000));


                $manager->persist($voiture);
            }
        }


        $manager->flush();
    }
}
