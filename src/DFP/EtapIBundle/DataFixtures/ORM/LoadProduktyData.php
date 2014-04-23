<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 09.02.14
 * Time: 13:24
 * To change this template use File | Settings | File Templates.
 */

namespace DFP\EtapIBundle\DataFixtures\ORM;

use DFP\EtapIBundle\Entity\Produkt;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadProduktyData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    function load(ObjectManager $manager)
    {
        $yml = Yaml::parse('data/Produkty.yml');

        foreach($yml as $p)
        {
            $produkt = new Produkt();
            $produkt->setNazwaHandlowa($p['nazwa']);
            $produkt->setUwagi($p['opis']);

            $manager->persist($produkt);
        }

        $manager->flush();
    }
}