<?php
namespace HltvApi\Interfaces;


interface Request
{
    public function sendRequest() : string;
}