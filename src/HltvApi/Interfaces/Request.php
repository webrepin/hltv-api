<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.10.2019
 * Time: 8:08
 */

namespace HltvApi\Interfaces;


interface Request
{
    public function sendRequest() : string;
}