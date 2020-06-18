<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
    	'key',
    	'value',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function ($setting) {
            cache()->forget('settings');
            config()->set('settings.' . $setting->key, $setting->value);
        });
        static::deleted(function ($setting) {
            cache()->forget('settings');
            config()->offsetUnset('settings.' . $setting->key);
        });
    }
}
