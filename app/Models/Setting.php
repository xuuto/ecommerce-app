<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';
    protected $fillable = ['key', 'value'];

    /**
     * @param $key
     */
    public static function get($key)
    {
        $setting = new self();
        $entry = $setting->where('key', $key)->first();
        if (!$entry) {
            return;
        }
        return $entry->value;
    }

    public static function set($key, $value = null)
    {
        $setting = new self();
        $entry = $setting->where('key', $key)->firstorFail();
        $entry->value = $value;
        $entry->saveorFail();
        // config::set('key', $value);
        Config::set('key', $value);
        if (Config::get($key) == $value) {
            return true;
        }
        return false;
    }
}
