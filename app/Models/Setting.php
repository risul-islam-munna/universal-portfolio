<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Key-value settings store.
 *
 * Rows are keyed by (theme, key). The `theme` column scopes settings to a
 * specific theme package (e.g. 'default', 'photographer'). Global site
 * settings always live under theme = 'default'.
 */
class Setting extends Model
{
    protected $fillable = ['theme', 'key', 'value', 'status'];

    protected $casts = ['status' => 'boolean'];

    /** Retrieve the value for a key in the given theme scope. */
    public static function getValue(string $key, mixed $default = null, string $theme = 'default'): mixed
    {
        $row = static::where('theme', $theme)
            ->where('key', $key)
            ->where('status', true)
            ->value('value');

        return $row ?? $default;
    }

    /** Persist a single key–value pair, creating the row if it does not exist. */
    public static function setValue(string $key, mixed $value, string $theme = 'default'): void
    {
        static::updateOrCreate(
            ['theme' => $theme, 'key' => $key],
            ['value' => $value, 'status' => true],
        );
    }

    /** Return all active settings for a theme as a plain key → value array. */
    public static function forTheme(string $theme = 'default'): array
    {
        return static::where('theme', $theme)
            ->where('status', true)
            ->pluck('value', 'key')
            ->toArray();
    }

    /** Bulk-upsert an array of key → value pairs for a theme. */
    public static function setMany(array $pairs, string $theme = 'default'): void
    {
        foreach ($pairs as $key => $value) {
            static::setValue($key, $value, $theme);
        }
    }
}
