<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cache;

class Setting extends Model
{
	use SoftDeletes;


	public static function get($key)
	{
		if (Cache::has($key)) {
			return Cache::get($key);
		} else {
			$values = self::where('key', $key)->pluck('value')->first();
			Cache::put($key, $values);
			return self::where('key', $key)->pluck('value')->first();
		}
	}

	public static function set($key, $value)
	{
		if (self::where('key', $key)->first() == null) {
			$data = array('key' => $key, 'value' => $value);
			return self::insert($data);
		} else {
			$data = array('value' => $value);
			return self::where('key', $key)->update($data);
		}
	}
}
