<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 30/06/15
 * Time: 10:37
 */

namespace Fer\HelpersBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;
/**
 * Class Csrf
 * @Annotation
 * @Target("METHOD")
 */
final class Csrf extends Annotation
{
    /**
     * @var string Intention for CSRF token
     */
    public $intention;
    /**
     * @var string
     */
    public $param = '_csrf';

    public $stateless = false;

    public $csrf_header =  'X-Csrf-Token';
}