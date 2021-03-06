<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProfilDzialalnosciRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProfilDzialalnosciRepository extends EntityRepository
{
    public function findAllOrderByName()
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('pd')
            ->from('DFPEtapIBundle:profilDzialalnosci', 'pd')
            ->orderBy('pd.nazwaProfilu','ASC')
            ->getQuery()
            ->getResult();
    }
}
