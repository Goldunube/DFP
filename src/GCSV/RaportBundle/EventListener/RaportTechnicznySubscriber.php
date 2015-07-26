<?php

namespace GCSV\RaportBundle\EventListener;


use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use GCSV\RaportBundle\Entity\RaportTechniczny;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RaportTechnicznySubscriber implements EventSubscriber
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'postUpdate'
        );
    }
    
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if($entity instanceof RaportTechniczny)
        {
            /**
             * @var $raportTechniczny $raportTechniczny
             */
            $raportTechniczny = $entity;
            $securityContext = $this->container->get('security.context');

            $raportTechniczny->setAutor($securityContext->getToken()->getUser());
            $raportTechniczny->setModyfikujacy($securityContext->getToken()->getUser());
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if($entity instanceof RaportTechniczny)
        {
            /**
             * @var $raportTechniczny $raportTechniczny
             */
            $raportTechniczny = $entity;
            $securityContext = $this->container->get('security.context');

            $raportTechniczny->setModyfikujacy($securityContext->getToken()->getUser());
        }
    }
} 