<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 7/1/15
 * Time: 10:54
 */
namespace Fer\HelpersBundle\CQRS;

interface AggregateIdInterface
{
    public function id();
    public function equals(AggregateIdInterface $aggregateId);
}
