<?php

namespace DFP\EtapIBundle\DataFixtures\ORM;

use DFP\EtapIBundle\Entity\MaterialUzupelniajacy;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadMaterialyUzupelniajaceData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    public function load(ObjectManager $manager)
    {
        $yml = Yaml::parse('data/MaterialyUzupelniajace.yml');
        foreach($yml as $m)
        {
            $matUz = new MaterialUzupelniajacy();
            $matUz->setNazwa($m['Nazwa']);
            $matUz->setOpis($m['Opis']);

            $manager->persist($matUz);
        }
            $manager->flush();
    }
}