<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 29/06/15
 * Time: 11:11
 */

namespace Fer\HelpersBundle\Validator\Constraints;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ChoiceFromConfigValidator extends ConstraintValidator {

    /**
     * @var $container ContainerInterface
     */
    protected $container;

    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ChoiceFromConfig) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\ChoiceFromConfig');
        }

        if (!$this->container->hasParameter($constraint->configEntry) || !is_array($this->container->getParameter($constraint->configEntry))) {
            throw new ConstraintDefinitionException('"configEntry"" must be specified on constraint ChoiceFromConfig pointing to a config array');
        }

        $choices = $this->container->getParameter($constraint->configEntry);

        if ($constraint->multiple) {
            foreach ($value as $_value) {
                if (!in_array($_value, $choices, $constraint->strict)) {
                    if ($this->context instanceof ExecutionContextInterface) {
                        $this->context->buildViolation($constraint->multipleMessage)
                            ->setParameter('{{ value }}', $this->formatValue($_value))
                            ->setCode(ChoiceFromConfig::NO_SUCH_CHOICE_ERROR)
                            ->setInvalidValue($_value)
                            ->addViolation();
                    } else {
                        $this->buildViolation($constraint->multipleMessage)
                            ->setParameter('{{ value }}', $this->formatValue($_value))
                            ->setCode(ChoiceFromConfig::NO_SUCH_CHOICE_ERROR)
                            ->setInvalidValue($_value)
                            ->addViolation();
                    }

                    return;
                }
            }

            $count = count($value);

            if ($constraint->min !== null && $count < $constraint->min) {
                if ($this->context instanceof ExecutionContextInterface) {
                    $this->context->buildViolation($constraint->minMessage)
                        ->setParameter('{{ limit }}', $constraint->min)
                        ->setPlural((int) $constraint->min)
                        ->setCode(ChoiceFromConfig::TOO_FEW_ERROR)
                        ->addViolation();
                } else {
                    $this->buildViolation($constraint->minMessage)
                        ->setParameter('{{ limit }}', $constraint->min)
                        ->setPlural((int) $constraint->min)
                        ->setCode(ChoiceFromConfig::TOO_FEW_ERROR)
                        ->addViolation();
                }

                return;
            }

            if ($constraint->max !== null && $count > $constraint->max) {
                if ($this->context instanceof ExecutionContextInterface) {
                    $this->context->buildViolation($constraint->maxMessage)
                        ->setParameter('{{ limit }}', $constraint->max)
                        ->setPlural((int) $constraint->max)
                        ->setCode(ChoiceFromConfig::TOO_MANY_ERROR)
                        ->addViolation();
                } else {
                    $this->buildViolation($constraint->maxMessage)
                        ->setParameter('{{ limit }}', $constraint->max)
                        ->setPlural((int) $constraint->max)
                        ->setCode(ChoiceFromConfig::TOO_MANY_ERROR)
                        ->addViolation();
                }

                return;
            }
        } elseif (!in_array($value, $choices, $constraint->strict)) {
            if ($this->context instanceof ExecutionContextInterface) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(ChoiceFromConfig::NO_SUCH_CHOICE_ERROR)
                    ->addViolation();
            } else {
                $this->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(ChoiceFromConfig::NO_SUCH_CHOICE_ERROR)
                    ->addViolation();
            }
        }
    }
}