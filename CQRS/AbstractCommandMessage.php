<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 16/09/14
 * Time: 22:30
 */
namespace Fer\HelpersBundle\CQRS;

use Fer\HelpersBundle\Traits\ArrayToPropertiesTrait;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;

/**
 * Default CQRS DDD Command configured for SimpleBus named Messages
 * Class DefaultCommand
 * @package Fer\HelpersBundle\CQRS
 */
abstract class AbstractCommandMessage implements CommandInterface
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

    protected function buildFromEntity($entity) {
        self::mapProperties($entity, $this);
    }
    /**
     * Initializes a $command properties from an $entity
     *
     * @param $target
     * @param $source
     * @return $command
     */
    private static function mapProperties($source, $target)
    {
        $properties = get_class_vars(get_class($target));
        foreach ($properties as $prop => $propValue) {
            try {
                // ejp getDescription()
                $method = 'get'.ucfirst($prop);
                if (method_exists($source, $method)) {
                    $target->$prop = $source->$method();
                }

                // ejp isReady()
                $method = 'is'.ucfirst($prop);
                if (method_exists($source, $method)) {
                    $target->$prop = $source->$method();
                }

                //ejp name()
                $method = $prop;
                if (method_exists($source, $method)) {
                    $target->$prop = $source->$method();
                }
            } catch (NoSuchPropertyException $exception) {
            }
        }

        return $target;
    }
}
