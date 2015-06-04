<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 15/11/14
 * Time: 22:20
 */
namespace Fer\HelpersBundle\Traits;

trait ArrayToPropertiesTrait
{
    protected function arrayToProperties($dataArray)
    {
        foreach ($dataArray as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
