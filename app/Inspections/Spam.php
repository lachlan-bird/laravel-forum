<?php

namespace App\Inspections;

/**
 * Class Spam
 * @package App\Inspections
 */
class Spam
{
    /**
     * @var array
     */
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    /**
     * @param $body
     * @return bool
     */
    public function detect($body)
    {
        foreach($this->inspections as $inspection)
        {
            app($inspection)->detect($body);
        }

        return false;
    }
}