<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

   protected $guarded = [];

    public function organizations()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function camp() {
        return $this->belongsTo(Camp::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'patient_id', 'id');
    }

    // public function reports()
    // {
    //     return $this->belongsTo(Report::class,'id','patient_id');
    // }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
