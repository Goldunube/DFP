<?php

namespace GCSV\RaportBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * RaportTechniczny
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RaportTechnicznyRepository extends EntityRepository
{
    public function znajdzWszystkieMojeRaportyQuery($user)
    {
        $raporty = Array();

        // RAPORTY TECHNICZNE
        $query = $this->getEntityManager()->getRepository('GCSVRaportBundle:RaportTechniczny')->createQueryBuilder('rt')
            ->select('rt')
            ->where('rt.autor = :user')
            ->setParameter('user',$user);
        $raporty = $query->getQuery()->getResult();

        return $raporty;
    }

    public function getRaportyTechniczneByZakres(\DateTime $dataOd, \DateTime $dataDo)
    {
        $query = $this->createQueryBuilder('rt')
            ->select('rt,a,zt,uzt,t')
            ->leftJoin('rt.autor','a')
            ->leftJoin('rt.zdarzenieTechniczne','zt')
            ->leftJoin('zt.uczestnikZdarzeniaTechnicznego','uzt')
            ->leftJoin('uzt.terminy','t')
            ->where('t.rozpoczecieWizyty <= :dataDo')
            ->andwhere('t.zakonczenieWizyty >= :dataOd')
            ->setParameters(array(
                    'dataOd'    =>  $dataOd->format('Y-m-d'),
                    'dataDo'    =>  $dataDo->format('Y-m-d')
                )
            )->getQuery();

        return $query->getResult();
    }
} 