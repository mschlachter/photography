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
    
    protected $fillable = [
        'name',
        'tag_category_id',
    ];

    public function category()
    {
        return $this->hasOne(TagCategory::class);
    }
    
    public function images()
    {
        return $this->belongsToMany(Image::class);
    }
}
