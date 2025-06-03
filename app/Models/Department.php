<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = "department";

    public function testProfile()
    {
        return $this->hasOne(TestProfile::class, 'department_id', 'id');
    }

    public function testSubProfile()
    {
        return $this->hasOne(TestSubprofile::class, 'department_id', 'id');
    }

    public function test()
    {
        return $this->hasOne(Test::class, 'department_id', 'id');
    }
}
