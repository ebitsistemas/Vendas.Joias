<?php

namespace App\Traits;

use App\Models\Cache;
use Carbon\Carbon;

trait TraitCommon
{
    public function reportPutCache($key, $value)
    {
        Cache::create([
            'key' => $key,
            'value' => $value,
            'expiration' => Carbon::now()->addDay()->timestamp
        ]);
    }

    public function reportGetCache($key)
    {
        return Cache::where('key', $key)->first();
    }

    public function reportForgetCache($key)
    {
        Cache::where('key', $key)->delete();
    }
}
