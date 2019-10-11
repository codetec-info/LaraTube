<?php

namespace Laratube;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Str;

class Model extends BaseModel
{
    /**
     * Disable id incrementing
     * @var bool
     */
    public $incrementing = false;

    /**
     * Prevent mass assignment protection
     * @var array
     */
    protected $guarded = [];

    /**
     * Set the id to take uuid when $incrementing is false
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string)Str::uuid();
        });
    }
}
