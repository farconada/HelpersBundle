<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 26/7/15
 * Time: 16:35
 */

namespace Fer\HelpersBundle\CQRS;


use SimpleBus\Message\Name\NamedMessage;

interface CommandInterface extends NamedMessage
{
    public static function messageName();
}