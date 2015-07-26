<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 26/7/15
 * Time: 17:10
 */

namespace Fer\HelpersBundle\CQRS;


use SimpleBus\Message\Name\NamedMessage;

interface DomainEventInterface extends NamedMessage
{
    public static function messageName();
}