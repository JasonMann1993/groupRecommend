<?php
/**
 * Created by PhpStorm.
 * User: jialin
 * Date: 25/10/2017
 * Time: 17:21
 */

namespace App\Api\Controllers\Manage;


use Dingo\Api\Exception\ValidationHttpException;

trait Helpers
{

    public function throwValidationHttpException($message)
    {
        throw new ValidationHttpException(['error' => $message]);
    }

}