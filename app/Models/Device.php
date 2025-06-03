<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public function category()
    {
        return $this->belongsTo(DeviceCatalog::class, 'device_code');
    }

    public function organizations()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function camps()
    {
        return $this->hasMany(Camp::class,'organization_id');
    }

}
