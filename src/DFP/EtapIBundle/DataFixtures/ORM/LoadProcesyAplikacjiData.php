<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 08.02.14
 * Time: 11:34
 * To change this template use File | Settings | File Templates.
 */

namespace DFP\EtapIBundle\DataFixtures\ORM;

use DFP\EtapIBundle\Entity\ProcesAplikacji;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadProcesyAplikacjiData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    function load(ObjectManager $manager)
    {
        $yml = Yaml::parse('data/ProcesyAplikacji.yml');

        foreach ($yml as $pa) {
            $proces = new ProcesAplikacji();
            $proces->setNazwaProcesu($pa['Nazwa']);
            $proces->setOpis($pa['Opis']);
            $manager->persist($proces);
        }
            $manager->flush();
    }
}