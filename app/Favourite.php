<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Favourite
 * @package App
 */
class Favourite extends Model
{
    use RecordsActivity;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function favourited() {
        return $this->morphTo();
    }
}
