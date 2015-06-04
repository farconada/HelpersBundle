<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 19/1/15
 * Time: 17:12
 */
namespace Fer\HelpersBundle\CQRS;

use SimpleBus\Message\Recorder\PrivateMessageRecorderCapabilities;

abstract class BaseAggregateRoot implements AggregateRootInterface
{

    use PrivateMessageRecorderCapabilities;
}
