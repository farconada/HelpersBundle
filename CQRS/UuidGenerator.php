<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 16/09/14
 * Time: 22:47
 */
namespace Fer\HelpersBundle\CQRS;

use Ramsey\Uuid\Uuid;

class UuidGenerator
{
    /**
     * Returns an Uuid string
     *
     * @return string Uuid
     */
    public static function generate()
    {
        return Uuid::uuid4()->toString();
    }
}
