<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 7/1/15
 * Time: 10:54
 */
namespace Fer\HelpersBundle\CQRS;

/**
 * Interface AggregateIdInterface
 * @package Fer\HelpersBundle\CQRS
 */
interface AggregateIdInterface
{
    /**
     * Return the Id string
     *
     * @return string
     */
    public function getId();

    /**
     * Return true if and ID object is equals
     *
     * @param AggregateIdInterface $aggregateId
     * @return bool
     */
    public function equals(AggregateIdInterface $aggregateId);
}
