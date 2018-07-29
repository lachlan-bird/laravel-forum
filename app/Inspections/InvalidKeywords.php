<?php

namespace App\Inspections;

use Exception;

/**
 * Class InvalidKeywords
 * @package App\Inspections
 */
class InvalidKeywords
{
    /**
     * @var array
     */
    protected $keywords = [
        'yahoo customer support'
    ];

    /**
     * @param $text
     * @throws Exception
     */
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