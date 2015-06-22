<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 14/6/15
 * Time: 9:48
 */

namespace Fer\HelpersBundle\CQRS;


use Doctrine\Common\Collections\Criteria;
use Fer\HelpersBundle\CQRS\AggregateRootInterface;

interface RepositoryInterface {
    public function nextIdentity(AggregateIdInterface $id = null);
    public function getOfIdentity(AggregateIdInterface $id);
    public function save(AggregateRootInterface $entity);
    public function remove(AggregateRootInterface $entity);
    public function findAll();
}