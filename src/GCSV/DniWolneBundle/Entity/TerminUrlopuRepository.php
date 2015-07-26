<?php

namespace GCSV\DniWolneBundle\Entity;

use Doctrine\ORM\EntityRepository;
use GCSV\UserBundle\Entity\Uzytkownik;

/**
 * TerminUrlopuRepository
 *
 * @package GCSV\DniWolneBundle\Entity
 */
class TerminUrlopuRepository extends EntityRepository
{
    public function getTerminyUrlopowByZakres(\DateTime $dataOd, \DateTime $dataDo)
    {
        $query = $this->createQueryBuilder('tu')
            ->select('tu,o')
            ->leftJoin('tu.osoba','o')
            ->where('tu.start <= :dataDo')
            ->andwhere('tu.koniec >= :dataOd')
            ->setParameters(array(
                    'dataOd'    =>  $dataOd->format('Y-m-d'),
                    'dataDo'    =>  $dataDo->format('Y-m-d')
                )
            )->getQuery();

        return $query->getResult();
    }

    public function getTerminyUrlopowByOsobaZakres(Uzytkownik $uzytkownik, \DateTime $dataOd, \DateTime $dataDo)
    {
        $query = $this->createQueryBuilder('tu')
            ->select('tu,o')
            ->leftJoin('tu.osoba','o')
            ->where('tu.start <= :dataDo')
            ->andwhere('tu.koniec >= :dataOd')
            ->andwhere('tu.osoba = :osoba')
            ->setParameters(array(
                    'osoba'     =>  $uzytkownik,
                    'dataOd'    =>  $dataOd->format('Y-m-d'),
                    'dataDo'    =>  $dataDo->format('Y-m-d')
                )
            )->getQuery();

        return $query->getResult();
    }
}