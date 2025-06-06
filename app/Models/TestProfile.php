<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestProfile extends Model
{
    protected $table="test_profile";

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function subProfile()
    {
        return $this->hasMany(TestProfile::class, 'profile_id', 'id');
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'profile_id', 'id');
    }
}
