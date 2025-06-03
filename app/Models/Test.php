<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = "tests";
    
    public function testProfile()
    {
        return $this->belongsTo(TestProfile::class, 'profile_id'); // or 'test_profile_id' if that's your field name
    }

    public function testSubprofile()
    {
        return $this->belongsTo(TestSubprofile::class, 'sub_profile_id'); // update if needed
    }

    public function packages()
    {
        return $this->belongsTo(Package::class, 'package_tests', 'test_id', 'package_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
