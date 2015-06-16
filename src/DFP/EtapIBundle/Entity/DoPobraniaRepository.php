<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DoPobraniaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DoPobraniaRepository extends EntityRepository
{
    public function findAllBySort()
    {
        $query = $this->createQueryBuilder('p')
            ->select('p,a,z')
            ->leftJoin('p.author','a')
            ->leftJoin('p.zalacznik','z')
            ->orderBy('p.sort')
            ->where('p.wiadomosciShow IN (0,2)')
            ->getQuery();

        return $query->getResult();
    }

    public function findAllAktualnosciBySort()
    {
        $query = $this->createQueryBuilder('p')
            ->select('p,a,z')
            ->leftJoin('p.author','a')
            ->leftJoin('p.zalacznik','z')
            ->orderBy('p.przyklejony','DESC')
            ->addOrderBy('p.sort')
            ->where('p.wiadomosciShow IN (1,2)')
            ->getQuery();

        return $query->getResult();
    }
} 