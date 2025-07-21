@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

    {{-- Page Title --}}

    <div class="pagetitle">

        <h1>Roles</h1>

        <div class="row">

            <div class="col-md-8">

                <nav>

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>

                        <li class="breadcrumb-item active">Create</li>

                    </ol>

                </nav>

            </div>

        </div>

    </div>



    {{-- Create Role Section --}}

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fs-5 fw-bold form-label">Role Name <span class="text-danger">*</span></label>

                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : '' }}" placeholder="Enter Role Name">

                                    @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <label class="fs-5 fw-bold form-label">Role Permissions</label>
                                    <table class="table">
                                        <tbody class="fw-semibold">
                                            <tr>
                                                <td><label style="cursor: pointer;" for="all_permissions" class="text-muted">ADMIN ACCESS</label></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="all_permissions">
                                                                <span class="form-check-label" for="all_permissions"> All Permissions </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- ORGANIZATIONS --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">ORGANIZATIONS</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['organization'])) ? $permissions['organization'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                         <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['organization.create'])) ? $permissions['organization.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['organization.edit'])) ? $permissions['organization.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                         <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['organization.delete'])) ? $permissions['organization.delete'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- MANAGERS --}}
                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">MANAGERS</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['managers'])) ? $permissions['managers'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['manager.create'])) ? $permissions['manager.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['manager.edit'])) ? $permissions['manager.edit'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">Edit </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['manager.delete'])) ? $permissions['manager.delete'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- PATHOLOGISTS --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">PATHOLOGISTS</span></td>
                                                
                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pathologists'])) ? $permissions['pathologists'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pathologist.create'])) ? $permissions['pathologist.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pathologist.edit'])) ? $permissions['pathologist.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pathologist.delete'])) ? $permissions['pathologist.delete'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- LAB TECHNICIANS --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">LAB TECHNICIANS</span></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['lab_technician'])) ? $permissions['lab_technician'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['lab_technician.create'])) ? $permissions['lab_technician.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['lab_technician.edit'])) ? $permissions['lab_technician.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['lab_technician.delete'])) ? $permissions['lab_technician.delete'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>
                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- PACKAGES --}}
                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">PACKAGES</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['package'])) ? $permissions['package'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['package.create'])) ? $permissions['package.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['package.edit'])) ? $permissions['package.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['package.delete'])) ? $permissions['package.delete'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>
                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- CAMPS --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">CAMPS</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['camp'])) ? $permissions['camp'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['camp.create'])) ? $permissions['camp.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['camp.edit'])) ? $permissions['camp.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['camp.delete'])) ? $permissions['camp.delete'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                       

                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- PATIENTS --}}
                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">PATIENTS</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['patient'])) ? $permissions['patient'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['patient.create'])) ? $permissions['patient.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['patient.edit'])) ? $permissions['patient.edit'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">Edit </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['patient.delete'])) ? $permissions['patient.delete'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>
                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- REVENUES --}}
                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">REVENUES</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['revenue'])) ? $permissions['revenue'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- BILLINGS --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">BILLINGS</span></td>

                                                <td>
                                                    <div class="row">

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['billing'])) ? $permissions['billing'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- QC REPORTS --}}
                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">QC REPORTS</span></td>

                                                <td>
                                                      <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['qc_report'])) ? $permissions['qc_report'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>


                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['qc_report.delete'])) ? $permissions['qc_report.delete'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>
                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- TESTS --}}
                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">TESTS</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test'])) ? $permissions['test'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.create'])) ? $permissions['test.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.edit'])) ? $permissions['test.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.delete'])) ? $permissions['test.delete'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                       
                                                    </div>

                                                </td>

                                            </tr>

                                            {{-- SATELLITE DATAS --}}
                                            <tr>

                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">SATELLITE DATAS</span></td>

                                                <td>

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['satellite_data'])) ? $permissions['satellite_data'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['satellite_data.delete'])) ? $permissions['satellite_data.delete'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>


                                            {{-- DEVICES --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">DEVICE</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device'])) ? $permissions['device'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                         <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.create'])) ? $permissions['device.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.edit'])) ? $permissions['device.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                         <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.delete'])) ? $permissions['device.delete'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- CATEGORY --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">CATEGORY</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.category'])) ? $permissions['device.category'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.category.create'])) ? $permissions['device.category.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.category.edit'])) ? $permissions['device.category.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.category.delete'])) ? $permissions['device.category.delete'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>


                                            
                                            {{-- DEPARTMENT --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">DEPARTMENT</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['department'])) ? $permissions['department'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['department.create'])) ? $permissions['department.create'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['department.delete'])) ? $permissions['department.delete'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">Delete </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>


                                            {{-- PATIENT REPORT --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">PATIENT REPORT</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['patient.report'])) ? $permissions['patient.report'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- TEST PROFILE --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">TEST PROFILE</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.profile'])) ? $permissions['test.profile'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.sub-profile.create'])) ? $permissions['test.sub-profile.create'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.sub-profile.delete'])) ? $permissions['test.sub-profile.delete'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">Delete </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>


                                            {{-- TEST SUB PROFILE --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">TEST SUB PROFILE</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.sub-profile'])) ? $permissions['test.sub-profile'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.sub-profile.create'])) ? $permissions['test.sub-profile.create'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.sub-profile.delete'])) ? $permissions['test.sub-profile.delete'] : '' }}" name="permissions[]">
                                                                <span class="form-check-label">Delete </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- ROLES --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">ROLES</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['roles.index'])) ? $permissions['roles.index'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['roles.create'])) ? $permissions['roles.create'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['roles.edit'])) ? $permissions['roles.edit'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['roles.destroy'])) ? $permissions['roles.destroy'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">Delete </span>

                                                            </label>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            {{-- ABHA REGISTER --}}
                                            <tr>
                                                <td class="text-muted"><span style="cursor: pointer" onclick="checkAllAfter(this)">ABHA REGISTER</span></td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['abha.register_patient'])) ? $permissions['abha.register_patient'] : '' }}" name="permissions[]">

                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <button class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('custom-js')
<script type="text/javascript">

    $("#all_permissions").change(function() {
        if(this.checked) {
            $(".form-check-input:not(#all_permissions)").prop('checked', true);
        } else {
            $(".form-check-input:not(#all_permissions)").prop('checked', false);
        }
    });



    function checkAllAfter(element) {

        let checkboxes = $(element).parent().nextAll('td').find('input[type="checkbox"]');

        checkboxes.each(function() {

            this.checked = !this.checked;

        });

    }
    
</script>

@endsection

