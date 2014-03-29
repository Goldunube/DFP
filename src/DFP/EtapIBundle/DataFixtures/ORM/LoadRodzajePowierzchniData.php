<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 29.03.2014
 * Time: 10:09
 */

namespace DFP\EtapIBundle\DataFixtures\ORM;

use DFP\EtapIBundle\Entity\RodzajPowierzchni;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadRodzajePowierzchniData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    function load(ObjectManager $manager)
    {
        $yml = Yaml::parse('data/RodzajePowierzchni.yml');

        foreach ($yml as $rp) {
            $rodzaj = new RodzajPowierzchni();
            $rodzaj->setNazwa($rp['Nazwa']);
            $rodzaj->setOpis($rp['Opis']);
            $manager->persist($rodzaj);
        }
        $manager->flush();
    }
}