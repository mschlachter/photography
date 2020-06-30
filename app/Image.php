<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @class Image
 * @property string $title
 * @property string $alt
 * @property Carbon $date
 * @property string $slug
 * @property Album $album
 * @property Collection<Tag> $tags
 */
class Image extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $fillable = [
        'title',
        'alt',
        'date',
        'album_id',
    ];
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($image) {
            // TODO: Add a check for whether it exists first:
            $image->slug = $image->id . '-' . \Str::slug($image->title, '-');
            return $image;
        });
    }
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }
    
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(450)
            ->height(450);
        $this->addMediaConversion('webp')
            ->format('webp')
            ->withResponsiveImages();
    }
    
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->orderBy('name');
    }
    
    public function getIsAlbumDefaultAttribute()
    {
        return $this->album->default_image_id == $this->id;
    }

    public function scopeActive($builder)
    {
        return $builder->whereHas('album', function($query) {
            return $query->active();
        });
    }
}
