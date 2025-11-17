<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description'
    ];

    protected $casts = [
        'value' => 'string'
    ];

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        // Always fetch from database to avoid cache issues
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return static::castValue($setting->value, $setting->type);
    }

    /**
     * Set setting value by key
     */
    public static function set($key, $value, $type = 'string', $description = null)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'description' => $description
            ]
        );

        // Clear cache for this specific setting
        Cache::forget('setting_' . $key);
        
        return $setting;
    }

    /**
     * Cast value based on type
     */
    private static function castValue($value, $type)
    {
        switch ($type) {
            case 'integer':
                return (int) $value;
            case 'boolean':
                // Handle boolean values correctly - strict comparison
                return in_array($value, ['1', 'true', true, 1], true);
            case 'array':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    /**
     * Get all settings as array
     */
    public static function getAll()
    {
        $settings = static::all();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->key] = static::castValue($setting->value, $setting->type);
        }

        return $result;
    }
}