<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 14/6/15
 * Time: 9:48
 */

namespace Fer\HelpersBundle\CQRS;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Fer\HelpersBundle\CQRS\AggregateRootInterface;

/**
 * Every Repository should implement this interface
 *
 * Interface RepositoryInterface
 * @package Fer\HelpersBundle\CQRS
 */
interface RepositoryInterface {
    /**
     * Generates a new Id object
     * @param AggregateIdInterface $id
     * @return AggregateIdInterface
     */
    public function nextIdentity(AggregateIdInterface $id = null);

    /**
     * Finds the object with $id
     *
     * @param AggregateIdInterface $id
     * @return AggregateRootInterface
     */
    public function getOfIdentity(AggregateIdInterface $id);

    /**
     * Persist an AggregateRoot object
     *
     * @param AggregateRootInterface $entity
     * @return null
     */
    public function save(AggregateRootInterface $entity);

    /**
     * Removes an entity from persistence
     *
     * @param AggregateRootInterface $entity
     * @return mixed
     */
    public function remove(AggregateRootInterface $entity);

    /**
     * Returns the whole collection of an Entity
     *
     * @return ArrayCollection
     */
    public function findAll();
}