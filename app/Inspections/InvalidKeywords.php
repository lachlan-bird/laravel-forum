<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords 
{
    protected $keywords = [
        'yahoo customer support'
    ];

    public function detect($text)
    {
        foreach($this->keywords as $keyword)
        {
            if(stripos($text, $keyword) !== false) 
            {
                throw new Exception('Text contains invalid keyword');
            }
        }
    }
}