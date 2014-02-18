<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 08.02.14
 * Time: 10:37
 * To change this template use File | Settings | File Templates.
 */

namespace DFP\EtapIBundle\DataFixtures\ORM;


use DFP\EtapIBundle\Entity\ProfilDzialalnosci;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadProfileDzialalnosciData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    public function load(ObjectManager $manager)
    {
        $yml = Yaml::parse('data/ProfileDzialalnosci.yml');

        foreach ($yml as $pd)
        {
            $profil = new ProfilDzialalnosci();
            $profil->setNazwaProfilu($pd['Nazwa']);
            $profil->setZweryfikowany(true);
            $manager->persist($profil);
        }
            $manager->flush();
    }
}