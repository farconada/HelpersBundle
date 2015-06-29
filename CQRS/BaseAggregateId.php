<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 7/1/15
 * Time: 10:56
 */
namespace Fer\HelpersBundle\CQRS;

/**
 * Abstract class with a default implementation for AggreateIDs
 *
 * Class BaseAggregateId
 * @package Fer\HelpersBundle\CQRS
 */
abstract class  BaseAggregateId
{

    /**
     * @var string
     */
    protected $id;

    /**
     * If not $id the builds a new Uuid
     * You should always pass and $id (from repository nextIdentity() ) even for Uuid,
     *
     * @param string $id
     */
    public function __construct($id = null)
    {
        $this->id = null === $id ? UuidGenerator::generate() : $id;
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param  AggregateIdInterface $userId
     * @return boolean
     */
    public function equals(AggregateIdInterface $aggregateId)
    {
        return $this->id() === $aggregateId->id();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }
}
