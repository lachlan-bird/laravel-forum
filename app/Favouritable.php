<?php

namespace App;

/**
 * Class Favouritable
 * @package App
 */
trait Favouritable
{
    /**
     *
     */
    protected static function bootFavouritable() {
        static::deleting(function ($model) {
            $model->favourites->each->delete();
        });
    }

    /**
     * @return mixed
     */
    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favourited');
    }

    /**
     * @return mixed
     */
    public function favourite()
    {
        $attributes = ['user_id' => auth()->id()];
        if(!$this->favourites()->where($attributes)->exists())
            return $this->favourites()->create($attributes);
    }

    /**
     *
     */
    public function unfavourite()
    {
        $attributes = ['user_id' => auth()->id()];
        $this->favourites()->where($attributes)->get()->each->delete();
    }

    /**
     * @return bool
     */
    public function isFavourited()
    {
        return !!$this->favourites->where('user_id', auth()->id())->count(); 
    }

    /**
     * @return bool
     */
    public function getIsFavouritedAttribute()
    {
        return $this->isFavourited();
    }

    /**
     * @return mixed
     */
    public function getFavouritesCountAttribute()
    {
        return $this->favourites->count();
    }
}