<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 08.02.14
 * Time: 11:58
 * To change this template use File | Settings | File Templates.
 */

namespace DFP\EtapIBundle\DataFixtures\ORM;


use DFP\EtapIBundle\Entity\WymaganiaPowloki;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadWymaganiaPowlokiData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    public function load(ObjectManager $manager)
    {
        $yml = Yaml::parse('data/WymaganiaPowloki.yml');

        foreach($yml as $wp)
        {
            $wymaganie = new WymaganiaPowloki();
            $wymaganie->setNazwaParametru($wp['Nazwa']);
            $wymaganie->setOpis($wp['Opis']);
            $manager->persist($wymaganie);
        }
            $manager->flush();
    }
}