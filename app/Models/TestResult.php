<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
