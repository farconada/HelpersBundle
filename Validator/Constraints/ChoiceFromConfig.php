<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 29/06/15
 * Time: 11:18
 */

namespace Fer\HelpersBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 *
 * @api
 */
class ChoiceFromConfig extends Constraint
{
    const NO_SUCH_CHOICE_ERROR = 1;
    const TOO_FEW_ERROR = 2;
    const TOO_MANY_ERROR = 3;

    protected static $errorNames = array(
        self::NO_SUCH_CHOICE_ERROR => 'NO_SUCH_CHOICE_ERROR',
        self::TOO_FEW_ERROR => 'TOO_FEW_ERROR',
        self::TOO_MANY_ERROR => 'TOO_MANY_ERROR',
    );

    public $configEntry;
    public $multiple = false;
    public $strict = false;
    public $min;
    public $max;
    public $message = 'The value you selected is not a valid choice.';
    public $multipleMessage = 'One or more of the given values is invalid.';
    public $minMessage = 'You must select at least {{ limit }} choice.|You must select at least {{ limit }} choices.';
    public $maxMessage = 'You must select at most {{ limit }} choice.|You must select at most {{ limit }} choices.';

    /**
     * {@inheritdoc}
     */
    public function getDefaultOption()
    {
        return 'configEntry';
    }

    public function validatedBy()
    {
        return 'choice_from_config';
    }
}