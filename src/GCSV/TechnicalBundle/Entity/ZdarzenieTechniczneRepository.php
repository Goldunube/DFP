<?php

namespace GCSV\TechnicalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ZdarzenieTechniczneRepository
 *
 * @package GCSV\TechnicalBundle\Entity
 */
class ZdarzenieTechniczneRepository extends EntityRepository
{
    public function getListaZdarzenTechnicznychQuery()
    {
        $query = $this->getEntityManager()->getRepository('GCSVTechnicalBundle:TerminZdarzeniaTechnicznego')->createQueryBuilder('tzt')
            ->select('tzt')
            ->leftJoin('tzt.uczestnikZdarzeniaTechnicznego','uzt')
            ->leftJoin('uzt.zdarzenieTechniczne','zt')
            ->leftJoin('uzt.osoba','os')
            ->getQuery();

        return $query;
    }

    public function getListaMoichWizytQuery($userId)
    {
        $query = $this->getEntityManager()->getRepository('GCSVTechnicalBundle:TerminZdarzeniaTechnicznego')->createQueryBuilder('tzt')
            ->select('tzt,uzt,zt,os,rzt,odf,fi,rec,rap')
            ->leftJoin('tzt.uczestnikZdarzeniaTechnicznego','uzt')
            ->leftJoin('uzt.zdarzenieTechniczne','zt')
            ->leftJoin('uzt.osoba','os')
            ->leftJoin('zt.oddzialFirmy','odf')
            ->leftJoin('zt.rodzajZdarzeniaTechnicznego','rzt')
            ->leftJoin('odf.firma','fi')
            ->leftJoin('zt.receptury','rec')
            ->leftJoin('zt.raportyTechniczne','rap')
            ->where('os.id = :user')
            ->setParameter('user',$userId)
            ->orderBy('tzt.rozpoczecieWizyty','DESC')
            ->getQuery();

        return $query;
    }

    public function getRaportyTechniczne($zdarzenieId)
    {
        $query = $this->getEntityManager()->getRepository('GCSVRaportBundle:RaportTechniczny')->createQueryBuilder('rt')
            ->select('rt')
            ->where('rt.zdarzenieTechniczne = :zdarzenie')
            ->setParameter('zdarzenie', $zdarzenieId)
            ->getQuery();

        return $query->getResult();
    }
} 