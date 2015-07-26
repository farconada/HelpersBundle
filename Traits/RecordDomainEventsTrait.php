<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 26/7/15
 * Time: 16:03
 */

namespace Fer\HelpersBundle\Traits;


use SimpleBus\Message\Recorder\PrivateMessageRecorderCapabilities;

trait RecordDomainEventsTrait
{
    use PrivateMessageRecorderCapabilities;
}