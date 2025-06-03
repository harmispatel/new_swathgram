<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestSubprofile extends Model
{
    protected $table = "test_subprofile";

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function profile()
    {
        return $this->belongsTo(TestProfile::class, 'profile_id', 'id');
    }
}
