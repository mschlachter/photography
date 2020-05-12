<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @class Album
 * @property string $title
 * @property Carbon $date
 * @property string $slug
 * @property Image $defaultImage
 * @property Collection<Image> $images
 */
class Album extends Model
{
    protected $fillable = [
        'title',
        'date',
        'default_image_id',
    ];
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($album) {
            // TODO: Add a check for whether it exists first:
            $album->slug = $album->date . '-' . \Str::slug($album->title, '-');
            return $album;
        });
    }
    
    public function defaultImage()
    {
        return $this->belongsTo(Image::class, 'default_image_id');
    }
    
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
