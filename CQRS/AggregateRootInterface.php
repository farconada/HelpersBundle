<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 10/1/15
 * Time: 13:26
 */
namespace Fer\HelpersBundle\CQRS;

use SimpleBus\Message\Recorder\ContainsRecordedMessages;

/**
 * Interface AggregateRootInterface
 *   could fire DDD Events
 *   has a method getId()
 * @package Fer\HelpersBundle\CQRS
 */
interface AggregateRootInterface extends ContainsRecordedMessages
{
    /**
     * @return AggregateIdInterface
     */
    public function getId();
}
