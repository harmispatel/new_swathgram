<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceCatalog extends Model
{
    protected $table = "device_catalog";
    public function devices()
    {
        return $this->hasMany(Device::class,'device_code');
    }
}
