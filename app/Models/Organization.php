<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $guarded = [];

    protected $casts = [
        'app_selection' => 'array',
    ];

    public function managers()
    {
        return $this->hasMany(Manager::class, 'organization_id', 'id');
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'organization_id', 'id');
    }

    public function pathologists()
    {
        return $this->belongsToMany(Pathologist::class, 'organization_pathologist', 'organization_id', 'pathologist_id');
    }

    public function lab_technician()
    {
        return $this->hasMany(LabTechnician::class, 'organization_id', 'id');
    }

    public function camps()
    {
        return $this->hasMany(Camp::class,'organization_id');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'organization_packages', 'organization_id', 'package_id');
    }


    public function devices()
    {
        return $this->hasMany(Device::class, 'organization_id', 'id');
    }

    public function camp()
    {
        return $this->hasMany(Camp::class, 'organization_id', 'id');
    }

     public function reports()
    {
        return $this->hasMany(Report::class, 'organization_id', 'id');
    }
}
