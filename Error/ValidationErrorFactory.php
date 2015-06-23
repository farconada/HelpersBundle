<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 23/6/15
 * Time: 17:55
 */

namespace Fer\HelpersBundle\Error;


use Fer\HelpersBundle\Exception\ValidationException;
use Symfony\Component\Validator\ConstraintViolation;
use Tbbc\RestUtil\Error\Error;
use Tbbc\RestUtil\Error\ErrorFactoryInterface;
use Tbbc\RestUtil\Error\Mapping\ExceptionMappingInterface;

class ValidationErrorFactory implements ErrorFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getIdentifier()
    {
        return 'validation_errors';
    }

    /**
     * @param ValidationException $exception
     * @param ExceptionMappingInterface $mapping
     * @return null|Error
     */
    public function createError(\Exception $exception, ExceptionMappingInterface $mapping)
    {

        if (!$this->supportsException($exception)) {
            return null;
        }

        $errorMessage = $mapping->getErrorMessage();
        if (empty($errorMessage)) {
            $errorMessage = $exception->getMessage();
        }

        $violations = $exception->getValidationErrors();
        $extendedMessage = [];
        /**
         * @var $violation ConstraintViolation
         */
        foreach ($violations as $violation) {
            $extendedMessage[] = ['property' => $violation->getPropertyPath(), 'error' => $violation->getMessage()];
        }



        return new Error($mapping->getHttpStatusCode(), $mapping->getErrorCode(), $errorMessage,
            $extendedMessage, $mapping->getErrorMoreInfoUrl());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsException(\Exception $exception)
    {
        return $exception instanceof ValidationException;
    }
}