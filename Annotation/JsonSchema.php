<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 13/10/15
 * Time: 9:09
 */

namespace Fer\HelpersBundle\Annotation;


use Doctrine\Common\Annotations\Annotation;
/**
 * Class Csrf
 * @Annotation
 * @Target("METHOD")
 */
final class JsonSchema extends Annotation
{
    /**
     * @var file in app/config/json-schema
     */
    public $file;

}