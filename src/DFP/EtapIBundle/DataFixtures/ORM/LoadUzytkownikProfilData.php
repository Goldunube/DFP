<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adam
 * Date: 06.02.14
 * Time: 15:19
 * To change this template use File | Settings | File Templates.
 */

namespace DFP\EtapIBundle\DataFixtures\ORM;

use DFP\EtapIBundle\Entity\ProfilUzytkownika;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUzytkownikProfilData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $profilUzytkownika = new ProfilUzytkownika();
        $profilUzytkownika->setPlec("Mężczyzna");
        $profilUzytkownika->setStanowisko('Administrator Portalu DFP');
        $profilUzytkownika->setKodPocztowy('00167');
        $profilUzytkownika->setMiejscowosc('Warszawa');
        $profilUzytkownika->setUlica('Anielewicza 15');
        $profilUzytkownika->setZainteresowania('Programowanie, Informatyka, Piłka nożna');


    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 2;
    }
}