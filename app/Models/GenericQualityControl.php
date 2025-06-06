<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenericQualityControl extends Model
{
    protected $table = "generic_quality_control";
    
    public function test()
    {
        return $this->hasOne(Test::class,'id','test_id');
    }
}
