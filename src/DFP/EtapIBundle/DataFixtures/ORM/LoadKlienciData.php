<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 09.02.14
 * Time: 13:24
 * To change this template use File | Settings | File Templates.
 */

namespace DFP\EtapIBundle\DataFixtures\ORM;


use DFP\EtapIBundle\Entity\Filia;
use DFP\EtapIBundle\Entity\Klient;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadKlienciData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    function load(ObjectManager $manager)
    {
        $yml = Yaml::parse('data/Filie.yml');

        foreach($yml as $k)
        {
            $klient = new Klient();
            $klient->setNazwaPelna($k['NazwaPelna']);
            $klient->setNazwaSkrocona($k['NazwaSkrocona']);
            $klient->setNip($k['NIP']);
            $klient->setAktywny(true);
            $klient->setDataZalozenia(new \DateTime());

            $filia = new Filia();
            $filia->setWojewodztwo(ucfirst($k['Wojewodztwo']));
            $filia->setKodPocztowy($k['Kod']);
            $filia->setMiejscowosc(ucfirst($k['Miejscowosc']));
            $filia->setUlica(ucfirst($k['Ulica']));
            $filia->setAktywna(true);
            if($k['NazwaFilii'] == null)
            {
                $filia->setNazwaFilii('Filia Główna');
            }else{
                $filia->setNazwaFilii($k['NazwaFilii']);
            }
            $filia->setKlient($klient);

            $manager->persist($klient);
            $manager->persist($filia);
        }

        $manager->flush();
    }
}