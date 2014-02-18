<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 08.02.14
 * Time: 11:53
 * To change this template use File | Settings | File Templates.
 */

namespace DFP\EtapIBundle\DataFixtures\ORM;


use DFP\EtapIBundle\Entity\WymaganiaProduktu;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadWymaganiaProduktuData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    function load(ObjectManager $manager)
    {
        $yml = Yaml::parse('data/WymaganiaProduktu.yml');

        foreach($yml as $wp)
        {
            $wymaganie = new WymaganiaProduktu();
            $wymaganie->setNazwaParametru($wp['Nazwa']);
            $wymaganie->setOpis($wp['Opis']);
            $manager->persist($wymaganie);
        }
            $manager->flush();
    }
}