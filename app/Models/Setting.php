<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['data'];

    protected $casts = ['data' => 'array'];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = static::first();

        return data_get($setting?->data, $key, $default);
    }

    public static function setValue(string $key, mixed $value): void
    {
        $setting = static::firstOrCreate([]);
        $data = $setting->data ?? [];
        data_set($data, $key, $value);
        $setting->update(['data' => $data]);
    }
}
