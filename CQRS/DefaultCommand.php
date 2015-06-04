<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 16/09/14
 * Time: 22:30
 */
namespace Fer\HelpersBundle\CQRS;

use Fer\HelpersBundle\Traits\ArrayToPropertiesTrait;
use SimpleBus\Message\Name\NamedMessage;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;

abstract class DefaultCommand implements NamedMessage
{
    use ArrayToPropertiesTrait;

    //Every Class should declare a COMMAND_NAME;
    const COMMAND_NAME = 'xxx';

    public function __construct(array $data = array())
    {
        $this->arrayToProperties($data);
    }

    public static function messageName()
    {
        // el "static" es importante para que devuelva el const de la clase Child
        return static::COMMAND_NAME;
    }

    protected static function mapProperties($command, $entity)
    {
        $properties = get_class_vars(get_class($command));
        foreach ($properties as $prop => $propValue) {
            try {
                $method = 'get'.ucfirst($prop);
                if (method_exists($entity, $method)) {
                    $command->$prop = $entity->$method();
                }
                $method = 'is'.ucfirst($prop);
                if (method_exists($entity, $method)) {
                    $command->$prop = $entity->$method();
                }
            } catch (NoSuchPropertyException $exception) {
            }
        }

        return $command;
    }
}
