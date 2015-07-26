<?php

namespace GCSV\TechnicalBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use GCSV\TechnicalBundle\Entity\TerminZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Entity\UczestnikZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne;
use GCSV\UserBundle\Entity\Uzytkownik;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ZdarzenieTechniczneSubscriber implements EventSubscriber
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
            'onFlush'
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if($entity instanceof ZdarzenieTechniczne)
        {
            /**
             * @var ZdarzenieTechniczne $zdarzenieTechniczne
             */
            $zdarzenieTechniczne = $entity;
            $securityContext = $this->container->get('security.token_storage');

            $zdarzenieTechniczne->setOsobaWprowadzajaca($securityContext->getToken()->getUser());
            $zdarzenieTechniczne->setOsobaModyfikujaca($securityContext->getToken()->getUser());

            $destDlugoscGeo = $zdarzenieTechniczne->getDlugoscGeo();
            $destSzerokoscGeo = $zdarzenieTechniczne->getSzerokoscGeo();
            if($destSzerokoscGeo and $destDlugoscGeo)
            {
                /**
                 * @var UczestnikZdarzeniaTechnicznego $uczestnikZdarzeniaTechnicznego
                 */
                foreach($zdarzenieTechniczne->getUczestnikZdarzeniaTechnicznego() as $uczestnikZdarzeniaTechnicznego)
                {
                    $requestDirections = $this->container->get('ivory_google_map.directions_request');
                    $curlHttpAdapter = $this->container->get('widop_http_adapter.curl');
                    $directions = $this->container->get('ivory_google_map.directions');

                    /**
                     * @var Uzytkownik $uzytkownik
                     */
                    $uzytkownik = $uczestnikZdarzeniaTechnicznego->getOsoba();
                    $orginSzerokoscGeo = floatval($uzytkownik->getProfil()->getLat());
                    $orginDlugoscGeo = floatval($uzytkownik->getProfil()->getLng());
                    $destSzerokoscGeo = floatval($destSzerokoscGeo);
                    $destDlugoscGeo = floatval($destDlugoscGeo);
                    $requestDirections->setOrigin($orginSzerokoscGeo,$orginDlugoscGeo,true);
                    $requestDirections->setDestination($destSzerokoscGeo,$destDlugoscGeo,true);
                    $requestDirections->setLanguage('pl');
                    $requestDirections->setRegion('pl');
                    $directions->setHttpAdapter($curlHttpAdapter);
                    $responseDirections = $directions->route($requestDirections);
                    $routes = $responseDirections->getRoutes();
                    $odleglosc = 0;
                    if($routes)
                    {
                        $legs = $routes[0]->getLegs();
                        $firstLeg = $legs[0];
                        $odleglosc = $firstLeg->getDistance()->getValue();
                    }
                    $uczestnikZdarzeniaTechnicznego->setDystans($odleglosc);
                }
            }
        }
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        $entities = array_merge(
            $uow->getScheduledEntityInsertions(),
            $uow->getScheduledEntityUpdates()
        );

        foreach ($entities as $entity) {
            if($entity instanceof TerminZdarzeniaTechnicznego)
            {
                $user = $this->container->get('security.token_storage')->getToken()->getUser();
                $zdarzenieTechniczne = $entity->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne();
                $zdarzenieTechniczne->setOsobaModyfikujaca($user);
                $md = $em->getClassMetadata('GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne');
                $uow->recomputeSingleEntityChangeSet($md,$zdarzenieTechniczne);
            }
        }
    }
} 