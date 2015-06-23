<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 22/06/15
 * Time: 12:41
 */

namespace Fer\HelpersBundle\ParamConverter;

use Fer\HelpersBundle\Exception\Array2CommandConverterException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Array2CommandConverter implements ParamConverterInterface {

    protected $validator;

    function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Stores the object in the request.
     *
     * @param Request $request The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $class = $configuration->getClass();
        $data = $request->get($configuration->getOptions()['param']) ? $request->get($configuration->getOptions()['param']): array();
        $command = new $class($data);
        $errors = $this->validator->validate($command);
        if(count($errors)){
            throw new Array2CommandConverterException($errors, "There are validation errors");
        }
        return true;
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        // Check, if option class was set in configuration
        if (null === $configuration->getClass() || !isset($configuration->getOptions()['param'])) {
            return false;
        }
        return true;
    }

}