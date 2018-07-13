<?php

namespace App\Inspections;

use Exception;

class KeyHeldDown 
{
    public function detect($text)
    {
        if(preg_match('/(.)\\1{4,}/', $text))
        {
            throw new \Exception('Text contains repeated characters');
        }
    }
}