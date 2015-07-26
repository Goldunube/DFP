<?php

namespace GCSV\MagazynBundle\Entity;


use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class ProduktRepository extends EntityRepository
{
    public function getProductsList($term = null,$array = false)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.indeks','DESC');

        if($term)
        {
            $query
                ->andWhere('p.indeks LIKE :term')
                ->orWhere('p.nazwa LIKE :term')
                ->setParameter('term','%'.$term.'%');
        }

        $query = $query->getQuery();

        $result = $array ? $query->getResult(AbstractQuery::HYDRATE_ARRAY) : $query->getResult();

        return $result;
    }
} 