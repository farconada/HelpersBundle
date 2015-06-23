<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 22/6/15
 * Time: 17:08
 */

namespace Fer\HelpersBundle\Exception;


use Exception;

class Array2CommandConverterException extends \Exception implements ValidationException
{
    protected $validationErrors;

    public function __construct($validationErrors = [], $message = "", $code = 0, Exception $previous = null)
    {
        $this->validationErrors = $validationErrors;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }


}