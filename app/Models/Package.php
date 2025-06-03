<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_packages', 'package_id', 'organization_id');
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'package_tests', 'package_id', 'test_id');
    }

    public function camps()
    {
        return $this->hasMany(Camp::class, 'package_id');
    }
}
