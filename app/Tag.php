<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @class Tag
 * @property string $name
 * @property TagCategory $category
 * @property Collection<Image> $images
 */
class Tag extends Model
{   
    public function category()
    {
        return $this->hasOne(TagCategory::class);
    }
    
    public function images()
    {
        return $this->belongsToMany(Image::class);
    }
}
