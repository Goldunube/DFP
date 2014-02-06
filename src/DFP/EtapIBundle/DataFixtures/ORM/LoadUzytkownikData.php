<?php

// src/DFP/EtapIBundle/DataFixtures/ORM/LoadUserData.php

namespace DFP\EtapIBundle\DataFixtures\ORM;

use DFP\EtapIBundle\Entity\ProfilUzytkownika;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use DFP\EtapIBundle\Entity\Uzytkownik;
use Symfony\Component\Yaml\Yaml;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $superAdministrator = $userManager->createUser();

        $superAdministrator->setUsername('Goldunube');
        $superAdministrator->setEmail('akrolikowski@csv.pl');
        $superAdministrator->setPlainPassword('batman123');
        $superAdministrator->setImie('Adam');
        $superAdministrator->setNazwisko('Królikowski');
        $superAdministrator->setSuperAdmin(true);
        $superAdministrator->setEnabled(true);
        $manager->persist($superAdministrator);

        $profilUzytkownika = new ProfilUzytkownika();
        $profilUzytkownika->setPlec("Mężczyzna");
        $profilUzytkownika->setStanowisko('Administrator Portalu DFP');
        $profilUzytkownika->setKodPocztowy('00167');
        $profilUzytkownika->setMiejscowosc('Warszawa');
        $profilUzytkownika->setUlica('Anielewicza 15');
        $profilUzytkownika->setZainteresowania('Programowanie, Informatyka, Piłka nożna');
        $manager->persist($profilUzytkownika);
        $superAdministrator->setProfilUzytkownika($profilUzytkownika);

        $yml = Yaml::parse('data/Uzytkownicy.yml');
        foreach ($yml as $u)
        {
            $uzytkownik = $userManager->createUser();

            $uzytkownik->setUsername($u['Username']);
            $uzytkownik->setEmail($u['Email']);
            $uzytkownik->setPlainPassword($u['Password']);
            $uzytkownik->setImie($u['Imie']);
            $uzytkownik->setNazwisko($u['Nazwisko']);
            $uzytkownik->setEnabled(true);
            $uzytkownik->setRoles(array($u['Role']));
            $manager->persist($uzytkownik);

            $profilUzytkownika = new ProfilUzytkownika();
            $profilUzytkownika->setPlec($u['Plec']);
            $profilUzytkownika->setStanowisko($u['Stanowisko']);
            $manager->persist($profilUzytkownika);
            $uzytkownik->setProfilUzytkownika($profilUzytkownika);

        }

        $manager->flush();

        $this->addReference('super-admin', $superAdministrator);
    }

    public function getOrder()
    {
        return 1;
    }
}