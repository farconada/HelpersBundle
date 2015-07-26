<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 16/09/14
 * Time: 22:34
 */
namespace Fer\HelpersBundle\CQRS;

use Fer\HelpersBundle\Traits\ArrayToPropertiesTrait;

/**
 * Default CQRS DDD Event configured for SimpleBus named Messages
 *
 * Class AbstractDomainEvent
 * @package Fer\HelpersBundle\CQRS
 */
abstract class AbstractDomainEvent implements DomainEventInterface
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
