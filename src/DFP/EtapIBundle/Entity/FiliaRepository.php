<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FiliaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FiliaRepository extends EntityRepository
{
    public function getListaFiliiQuery()
    {
        $query = $this->getEntityManager()->getRepository('DFPEtapIBundle:Filia')->createQueryBuilder('f')
            ->select('f, k, fu, u, pd')
            ->innerJoin('f.klient','k')
            ->leftJoin('f.filieUzytkownicy','fu')
            ->leftJoin('fu.uzytkownik','u')
            ->leftJoin('f.profileDzialalnosci','pd')
            ->getQuery();

        return $query;
    }

    public function findOneByZip($zip)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT f FROM DFPEtapIBundle:Filia f WHERE f.kodPocztowy = :zip")
            ->setParameter("zip",$zip)
            ->getOneOrNullResult();
    }
}
