<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 15/6/15
 * Time: 17:01
 */

namespace Fer\HelpersBundle\CQRS;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\QueryBuilder;
use Fer\HelpersBundle\CQRS\AggregateRootInterface;
use Doctrine\Common\Collections\Criteria;

/**
 * Trait with a basic implementation of RepositoryInterface for Doctrine ORM
 * Class BaseRepositoryTrait
 * @package Fer\HelpersBundle\CQRS
 */
trait BaseRepositoryTrait {
    public function nextIdentity(AggregateIdInterface $id = null)
    {
        if (!is_null($id)) {
            return $id;
        }
        $idClassName = $this->_class->getName() . 'Id';
        return new $idClassName();
    }

    public function filter(Criteria $criteria)
    {
        /**
         * @var $qb QueryBuilder
         */
        $qb = $this->createQueryBuilder('e');
        $qb->addCriteria($criteria);
        return $qb->getQuery()->getResult();
    }

    public function getOfIdentity(AggregateIdInterface $aggregateId)
    {
        $entity = $this->find($aggregateId->id());
        if (!$entity) {
            throw new EntityNotFoundException();
        }
        return $entity;
    }

    public function save(AggregateRootInterface $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
    }

    public function remove(AggregateRootInterface $entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush($entity);
    }

    /**
     * Returns a collection with all objects of an entity
     * If there is a field "position" then the collection is ordered by "position" ASC
     *
     * @return ArrayCollection
     */
    public function findAll() {
        $orderby = array_key_exists('position', $this->_class->columnNames) ? ['position' => 'ASC']: null;
        return $this->findBy(array(), $orderby);
    }
}