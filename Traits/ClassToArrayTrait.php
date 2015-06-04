<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 15/11/14
 * Time: 22:25
 */
namespace Fer\HelpersBundle\Traits;

trait ClassToArrayTrait
{
    protected function classToArray()
    {
        $data = array();

        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getProperties() as $property) {
            $data[$property->getName()] = $property->getValue($this);
        }

        return $data;
    }
}
