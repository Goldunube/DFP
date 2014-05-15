<?php

namespace DFP\EtapIBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use DFP\EtapIBundle\Entity\SystemMalarski;
use Doctrine\ORM\Event\OnFlushEventArgs;

class newSystemMalarski
{
    public function prePersist(LifecycleEventArgs $args)
    {
/*        $entity = $args->getEntity();

        if($entity instanceof SystemMalarski)
        {
            $em = $args->getEntityManager();

            $systemyMalarskieCollection = $em->getRepository('DFP\EtapIBundle\Entity\SystemMalarski')->findAll();

            foreach ($systemyMalarskieCollection as $znalezionySystemMalarski) {

                $znaleziony = $znalezionySystemMalarski->getProdukty()->toArray();
                $wprowadzany = $entity->getProdukty()->toArray();

                if(array_diff($wprowadzany, $znaleziony) || array_diff($znaleziony,$wprowadzany))
                {

                }else{
                    unset($entity);
                    $entity = $znalezionySystemMalarski;
                    $em->persist($entity);
                }

            }
        }*/
    }
}