<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 04.09.14
 * Time: 15:31
 */

namespace GCSV\TechnicalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GCSV\TechnicalBundle\Entity\RodzajZdarzeniaTechnicznego;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

class LoadRodzajeZdarzenData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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

    public function load(ObjectManager $manager)
    {
        $yml = Yaml::parse('data/RodzajeZdarzen.yml');

        foreach($yml as $rd)
        {
            $rodzajZdarzenia = new RodzajZdarzeniaTechnicznego();
            $rodzajZdarzenia->setNazwa($rd['nazwa']);
            $rodzajZdarzenia->setOpis($rd['opis']);
            $manager->persist($rodzajZdarzenia);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 0;
    }
} 