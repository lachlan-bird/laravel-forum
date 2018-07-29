<?php

namespace App\Inspections;

use Exception;

/**
 * Class KeyHeldDown
 * @package App\Inspections
 */
class KeyHeldDown
{
    /**
     * @param $text
     * @throws Exception
     */
    public function detect($text)
    {
        if(preg_match('/(.)\\1{4,}/', $text))
        {
            throw new \Exception('Text contains repeated characters');
        }
    }
}