<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class LabTechnician extends Authenticatable
{
    use HasApiTokens, Notifiable;
    
    protected $guarded = [];
    public function organizations()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    // public function camp()
    // {
    //     return $this->hasMany(Camp::class, 'lab_technician_id', 'id');
    // }

    public function camps()
    {
        return $this->belongsToMany(Camp::class, 'camp_lab_technicians', 'lab_technician_id', 'camp_id');
    }

    
}
