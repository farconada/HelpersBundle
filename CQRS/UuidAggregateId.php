<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 26/7/15
 * Time: 16:10
 */

namespace Fer\HelpersBundle\CQRS;


use Fer\HelpersBundle\CQRS\AggregateIdInterface;
use Fer\HelpersBundle\CQRS\UuidGenerator;

abstract class UuidAggregateId implements AggregateIdInterface
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  AggregateIdInterface $userId
     * @return boolean
     */
    public function equals(AggregateIdInterface $aggregateId)
    {
        return $this->getId() === $aggregateId->getId();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getId();
    }
}