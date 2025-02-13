<?php

namespace HydraStorage\HydraStorage\Expections;

class InvalidInputMediaFormat extends \Exception
{
    public function __construct($message = 'Invalid input media format')
    {
        parent::__construct($message);
    }
}
