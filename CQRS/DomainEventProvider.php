<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 16/09/14
 * Time: 22:12
 */
namespace Fer\HelpersBundle\CQRS;

use SimpleBus\Event\Provider\EventProviderCapabilities;

class DomainEventProvider
{
    use EventProviderCapabilities;
}
