<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 08.02.14
 * Time: 10:44
 * To change this template use File | Settings | File Templates.
 */

namespace DFP\EtapIBundle\DataFixtures\ORM;

use DFP\EtapIBundle\Entity\GrupaKlientow;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadGrupyKlientowData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    public function load(ObjectManager $manager)
    {
        $yml = Yaml::parse('data/GrupyKlientow.yml');

        foreach ($yml as $gk) {
            $grupaKlienta = new GrupaKlientow();
            $grupaKlienta->setNazwaGrupy($gk['Nazwa']);
            $manager->persist($grupaKlienta);
        }
            $manager->flush();
    }
}