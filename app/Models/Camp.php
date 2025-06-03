<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camp extends Model
{
    protected $guarded = [];

    public function organizations()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function pathologist()
    {
        return $this->belongsTo(Pathologist::class, 'pathologist_id', 'id');
    }

    public function labTechnicians()
    {
        return $this->belongsToMany(LabTechnician::class, 'camp_lab_technicians', 'camp_id', 'lab_technician_id');
    }
}
