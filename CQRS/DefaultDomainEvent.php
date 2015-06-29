<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 16/09/14
 * Time: 22:34
 */
namespace Fer\HelpersBundle\CQRS;

use Fer\HelpersBundle\Traits\ArrayToPropertiesTrait;
use SimpleBus\Message\Name\NamedMessage;

/**
 * Default CQRS DDD Event configured for SimpleBus named Messages
 *
 * Class DefaultDomainEvent
 * @package Fer\HelpersBundle\CQRS
 */
abstract class DefaultDomainEvent implements NamedMessage
{

    use ArrayToPropertiesTrait;

    public function __construct(array $data = array())
    {
        $this->arrayToProperties($data);
    }

    public static function messageName()
    {
        return self::EVENT_NAME;
    }
}
