<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $permissions = [
            // Organization
            'organization',
            'organization.create',
            'organization.edit',
            'organization.delete',

            // Manager
            'manager',
            'manager.create',
            'manager.edit',
            'manager.delete',

            // Pathologist
            'pathologists',
            'pathologist.create',
            'pathologist.edit',
            'pathologist.delete',

            // Lab Technician
            'lab_technician',
            'lab_technician.create',
            'lab_technician.edit',
            'lab_technician.delete',
            'lab_technician.patient',

            // Package
            'package',
            'package.create',
            'package.edit',
            'package.delete',

            // Camp
            'camp',
            'camp.create',
            'camp.edit',
            'camp.delete',

            // Patient
            'patient',
            'patient.create',
            'patient.edit',
            'patient.delete',

            // Revenue, Billing
            'revenue',
            'billing',

            // QC Report
            'qc_report',
            'qc_report.delete',

            // Test
            'test',
            'test.create',
            'test.edit',
            'test.delete',

            // Satellite Data
            'satellite_data',
            'satellite_data.delete',

            // Device
            'device',
            'device.create',
            'device.edit',
            'device.delete',

            // Device Category
            'device.category',
            'device.category.create',
            'device.category.edit',
            'device.category.delete',

            // Department
            'department',
            'department.create',
            'department.delete',

            //patient report
            'patient.report',

            // test profiles
            'test.profile',
            'test.profile.create',
            'test.profile.store',
            'test.profile.delete',

            //sub profile
            'test.sub-profile',
            'test.sub-profile.create',
            'test.sub-profile.store',
            'test.sub-profile.delete',

            //roles
            'roles.index',
            'roles.create',
            'roles.edit',
            'roles.destroy',

            'abha.register_patient'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}
