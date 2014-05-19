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
        $query = $this->getEntityManager()->getRepository('DFPEtapIBundle:FiliaUzytkownik')->createQueryBuilder('fu')
            ->select('fu')
            ->leftJoin('fu.filia','f')
            ->leftJoin('f.klient','k')
            ->where('fu.uzytkownik = :idu')
            ->setParameter('idu',$idu)
            ->getQuery();

        try{
            return $query->getResult();
        } catch(NoResultException $e) {
            return null;
        }
    }

    public function getZnajdzFilieUzytkownikaQuery($idu, $params = null)
    {
        $query = $this->getEntityManager()->getRepository('DFPEtapIBundle:FiliaUzytkownik')->createQueryBuilder('fu')
            ->select('fu')
            ->leftJoin('fu.filia','f')
            ->leftJoin('f.klient','k')
            ->where('fu.uzytkownik = :idu')
            ->setParameter('idu',$idu);

        if($params && is_array($params))
        {
            foreach($params as $key => $value)
            {
                $query->andWhere("k.$key LIKE '%$value%'");
            }
        }

        $query->getQuery();

        try{
            return $query;
        } catch(NoResultException $e) {
            return null;
        }
    }
}
