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

    // For display only:
    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_NUMBER = 'number';

    // For display only:
    public string $type = 'text';
    public string $label = '';

    // For display only:
    public static function getWithDefault(string $key, string $default = '', string $label = '', string $type = self::TYPE_TEXT) : self
    {
        $setting = new self([
            'key' => $key,
            'value' => config('settings.' . $key, $default),
        ]);

        $setting->label = $label;
        $setting->type = $type;

        return $setting;
    }
}
