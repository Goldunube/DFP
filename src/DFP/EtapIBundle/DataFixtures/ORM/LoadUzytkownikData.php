<?php

// src/DFP/EtapIBundle/DataFixtures/ORM/LoadUserData.php

namespace DFP\EtapIBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use DFP\EtapIBundle\Entity\Uzytkownik;

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
        $superAdministrator->setSuperAdmin(true);
        $superAdministrator->setEnabled(true);

        $manager->persist($superAdministrator);
        $manager->flush();

        $this->addReference('super-admin', $superAdministrator);
    }

    public function getOrder()
    {
        return 1;
    }
}