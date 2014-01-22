<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * FiliaUzytkownikRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FiliaUzytkownikRepository extends EntityRepository
{
    public function znajdzWszystkichKlientowUzytkownika($idu)
    {
        $query = $this->getEntityManager()->getRepository('DFPEtapIBundle:Klient')->createQueryBuilder('k')
            ->select('k')
            ->leftJoin('k.filie','f')
            ->leftJoin('f.filieUzytkownicy','fu')
            ->where('fu.uzytkownik = :idu')
            ->orderBy('k.nazwaSkrocona')
            ->setParameter('idu',$idu)
            ->getQuery();

        try{
            return $query->getResult();
        } catch(NoResultException $e) {
            return null;
        }
    }
}
