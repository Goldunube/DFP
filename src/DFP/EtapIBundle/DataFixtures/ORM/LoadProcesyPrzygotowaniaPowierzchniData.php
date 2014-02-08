<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 08.02.14
 * Time: 11:15
 * To change this template use File | Settings | File Templates.
 */

namespace DFP\EtapIBundle\DataFixtures\ORM;

use DFP\EtapIBundle\Entity\ProcesPrzygotowaniaPowierzchni;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadProcesyPrzygotowaniaPowierzchniData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    function load(ObjectManager $manager)
    {
        $yml = Yaml::parse('data/ProcesyPrzygotowaniaPowierzchni.yml');

        foreach ($yml as $ppp)
        {
            $proces = new ProcesPrzygotowaniaPowierzchni();
            $proces->setNazwaProcesu($ppp['Nazwa']);
            $proces->setOpis($ppp['Opis']);
            $manager->persist($proces);
        }
            $manager->flush();
    }
}