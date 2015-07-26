<?php

namespace GCSV\TechnicalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TerminZdarzeniaTechnicznegoRepository
 *
 * @package GCSV\TechnicalBundle\Entity
 */
class TerminZdarzeniaTechnicznegoRepository extends EntityRepository
{
    public function getTerminyZdarzenTechnicznychByZakres(\DateTime $dataOd, \DateTime $dataDo)
    {
        $query = $this->createQueryBuilder('tzt')
            ->select('tzt,uzt,zt,rzt,rt,os,gr,rzu,rec')
            ->leftJoin('tzt.uczestnikZdarzeniaTechnicznego','uzt')
            ->leftJoin('uzt.osoba','os')
            ->leftJoin('uzt.zdarzenieTechniczne','zt')
            ->leftJoin('zt.rodzajZdarzeniaTechnicznego','rzt')
            ->leftJoin('zt.raportyTechniczne','rt')
            ->leftJoin('zt.raportyZuzyc','rzu')
            ->leftJoin('zt.receptury','rec')
            ->leftJoin('os.grupy','gr')
            ->where('gr.nazwa = :grupa')
            ->andWhere('zt.status = 2')
            ->andwhere('tzt.rozpoczecieWizyty <= :dataDo')
            ->andwhere('tzt.zakonczenieWizyty >= :dataOd')
            ->setParameters(array(
                    'grupa'     =>  "Technik",
                    'dataOd'    =>  $dataOd->format('Y-m-d'),
                    'dataDo'    =>  $dataDo->format('Y-m-d')
                )
            )->getQuery();

        return $query->getResult();
    }

    public function getTerminyZdarzenTechnicznychByOsobaZakres($osoba, \DateTime $dataOd, \DateTime $dataDo)
    {
        $query = $this->createQueryBuilder('tzt')
            ->select('partial tzt.{id,rozpoczecieWizyty,zakonczenieWizyty,status}')
            ->addSelect('partial uzt.{id,dystans}')
            ->addSelect('partial zt.{id,oddzialFirmy,status}')
            ->addSelect('partial odf.{id,firma}')
            ->addSelect('partial fi.{id,nazwaSkrocona,nazwaPelna}')
            ->addSelect('partial rzt.{id,nazwa}')
            ->addSelect('rzu,rt,rec,nt')
            ->addSelect('ozl')
            ->leftJoin('tzt.uczestnikZdarzeniaTechnicznego','uzt')
            ->leftJoin('uzt.osoba','os')
            ->leftJoin('uzt.zdarzenieTechniczne','zt')
            ->leftJoin('zt.oddzialFirmy','odf')
            ->leftJoin('zt.rodzajZdarzeniaTechnicznego','rzt')
            ->leftJoin('zt.raportyTechniczne','rt')
            ->leftJoin('zt.notatki','nt')
            ->leftJoin('zt.raportyZuzyc','rzu')
            ->leftJoin('zt.osobaZlecajaca','ozl')
            ->leftJoin('zt.receptury','rec')
            ->leftJoin('odf.firma','fi')
            ->where('uzt.osoba = :osoba')
            ->andwhere('tzt.rozpoczecieWizyty <= :dataDo')
            ->andwhere('tzt.zakonczenieWizyty > :dataOd')
            ->orderBy('tzt.rozpoczecieWizyty')
            ->setParameters(array(
                    'osoba'     =>  $osoba,
                    'dataOd'    =>  $dataOd->format('Y-m-d'),
                    'dataDo'    =>  $dataDo->format('Y-m-d')
                )
            )->getQuery();

        return $query->getResult();
    }
}