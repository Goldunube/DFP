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
    public function getListaFiliiQuery($params = Array())
    {
        $query = $this->getEntityManager()->getRepository('DFPEtapIBundle:Filia')->createQueryBuilder('f')
            ->select('f, k, fu, u, pd')
            ->innerJoin('f.klient','k')
            ->leftJoin('f.filieUzytkownicy','fu')
            ->leftJoin('fu.uzytkownik','u')
            ->leftJoin('f.profileDzialalnosci','pd')
            ->orderBy('k.nazwaSkrocona','ASC');

        if(is_array($params) && !empty($params))
        {
            foreach($params as $key => $value)
            {
                $query->andWhere("k.$key LIKE '%$value%'");
            }
        }

        $query->getQuery();

        return $query;
    }

    public function getListaFiliiSearchQuery($kryteria = null)
    {
        $query = $this->getEntityManager()->getRepository('DFPEtapIBundle:Filia')->createQueryBuilder('f')
            ->select('f, k, fu, u, pd')
            ->innerJoin('f.klient','k')
            ->leftJoin('f.filieUzytkownicy','fu')
            ->leftJoin('fu.uzytkownik','u')
            ->leftJoin('f.profileDzialalnosci','pd')
            ->orderBy('k.nazwaSkrocona','ASC');

        if($kryteria)
        {
            $pole = $kryteria['filterField'];
            $wartosc = $kryteria['filterValue'];
            $query->where("$pole LIKE '%$wartosc%'");
        };

        $query->getQuery();

        return $query;
    }

    public function getWspolrzedneFilii($kryteria = null)
    {
        $query = $this->getEntityManager()->getRepository('DFPEtapIBundle:Filia')->createQueryBuilder('f')
            ->select('f.id, k.nazwaSkrocona, f.lat, f.lng')
            ->innerJoin('f.klient','k')
            ->leftJoin('f.filieUzytkownicy','fu')
            ->leftJoin('fu.uzytkownik','u')
            ->leftJoin('f.profileDzialalnosci','pd')
            ->orderBy('k.nazwaSkrocona','ASC');

        if($kryteria)
        {
            $pole = $kryteria['filterField'];
            $wartosc = $kryteria['filterValue'];
            $query->where("$pole LIKE '%$wartosc%'");
        };

        $result = $query->getQuery()->getArrayResult();

        return $result;
    }

    public function findOneByZip($zip)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT f FROM DFPEtapIBundle:Filia f WHERE f.kodPocztowy = :zip")
            ->setParameter("zip",$zip)
            ->getOneOrNullResult();
    }

    public function findLikeName($q)
    {
        return $this->createQueryBuilder('fi')
            ->select('fi,k')
            ->innerJoin('fi.klient','k')
            ->where('k.nazwaSkrocona LIKE :term')
            ->orWhere('k.kodMax LIKE :term')
            ->orWhere('k.nip LIKE :term')
            ->setParameter('term',"%$q%")
            ->getQuery()
            ->getResult();
    }
}
