<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 23/6/15
 * Time: 18:05
 */
namespace Fer\HelpersBundle\Exception;

interface ValidationException
{
    /**
     * @return array
     */
    public function getValidationErrors();
    public function getMessage();
}