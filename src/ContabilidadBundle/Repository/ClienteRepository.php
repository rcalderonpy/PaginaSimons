<?php

namespace ContabilidadBundle\Repository;

/**
 * ClienteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClienteRepository extends \Doctrine\ORM\EntityRepository
{
    public function buscarCliente($opciones=array(
                'ape1'=>'',
                'ape2'=>'',
                'nombres'=>'',
                'ruc'=>''
            ))
    {
        $em=$this->getEntityManager();

        $query=$em->createQueryBuilder()
            ->select('c')
            ->from('ContabilidadBundle:Cliente', 'c')
            ->Where("c.ruc like :ruc")
            ->andWhere("CONCAT(c.nombres, ' ', c.ape1, ' ', c.ape2) like :nombres")
            ->setParameter('ruc', '%'.$opciones['ruc'].'%')
            ->setParameter('nombres', '%'.$opciones['nombres'].'%')
            ->orderBy('c.nombres', 'ASC')
            ->getQuery();

        $clientes=$query->getResult();
        return $clientes;
    }
}
