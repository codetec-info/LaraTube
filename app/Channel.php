<?php

namespace Laratube;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * @property mixed user_id
 * @property mixed media
 */
class Channel extends Model implements HasMedia
{
    use HasMediaTrait;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        // If media exists
        if ($this->media->first())
            return $this->media->first()->getFullUrl('thumb');

        return null;
    }

    //
    public function editable()
    {
        // If user not logged in
        if (!auth()->check())
            return false;

        return $this->user_id == auth()->user()->id;
    }

    // Resize image before upload
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
