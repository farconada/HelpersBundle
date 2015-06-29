<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 19/1/15
 * Time: 17:12
 */
namespace Fer\HelpersBundle\CQRS;

use SimpleBus\Message\Recorder\PrivateMessageRecorderCapabilities;

/**
 * Abstract class for AggregateRoots and SimpleBus: ready to raise DDD events and a method getId()
 * Class BaseAggregateRoot
 * @package Fer\HelpersBundle\CQRS
 */
abstract class BaseAggregateRoot implements AggregateRootInterface
{
    use PrivateMessageRecorderCapabilities;
}
