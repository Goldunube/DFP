<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 08.02.14
 * Time: 11:45
 * To change this template use File | Settings | File Templates.
 */

namespace DFP\EtapIBundle\DataFixtures\ORM;

use DFP\EtapIBundle\Entity\ProcesUtwardzaniaPowloki;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadProcesyUtwardzaniaPowlokiData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    function load(ObjectManager $manager)
    {
        $yml = Yaml::parse('data/ProcesyUtwardzaniaPowloki.yml');

        foreach($yml as $pup)
        {
            $proces = new ProcesUtwardzaniaPowloki();
            $proces->setNazwaProcesu($pup['Nazwa']);
            $proces->setOpis($pup['Opis']);
            $manager->persist($proces);
        }
            $manager->flush();
    }
}