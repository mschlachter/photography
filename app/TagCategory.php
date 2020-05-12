<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @class TagCategory
 * @property name
 * @property Collection<Tag> $tags
 */
class TagCategory extends Model
{
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
