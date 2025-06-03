<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pathologist extends Model
{
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_pathologist', 'pathologist_id', 'organization_id');
    }

    public function camp()
    {
        return $this->hasMany(Camp::class, 'pathologist_id', 'id');
    }
}
