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

                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>

                        <li class="breadcrumb-item active">Edit</li>

                    </ol>

                </nav>

            </div>

        </div>

    </div>



    {{-- Edit Role Section --}}

    <section class="section dashboard">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <form action="{{ route('roles.update') }}" method="POST" enctype="multipart/form-data">

                            @csrf

                            <input type="hidden" name="id" id="id" value="{{ encrypt($role->id) }}">

                            <div class="row">

                                <div class="col-md-12">

                                    <label class="fs-5 fw-bold form-label">Role Name <span class="text-danger">*</span></label>

                                    <input type="text" name="name" id="name" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : '' }}" value="{{ old('name', $role->name) }}" placeholder="Enter Role Name">

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
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['organization'])) ? $permissions['organization'] : '' }}" name="permissions[]" {{ (isset($permissions['organization']) && in_array($permissions['organization'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                         <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['organization.create'])) ? $permissions['organization.create'] : '' }}" name="permissions[]" {{ (isset($permissions['organization.create']) && in_array($permissions['organization.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['organization.edit'])) ? $permissions['organization.edit'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['organization.edit']) && in_array($permissions['organization.edit'], $role_permissions)) ? 'checked' : '' }}
                                                                >

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                         <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['organization.delete'])) ? $permissions['organization.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['organization.delete']) && in_array($permissions['organization.delete'], $role_permissions)) ? 'checked' : '' }}
                                                                >

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['managers'])) ? $permissions['managers'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['managers']) && in_array($permissions['managers'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['manager.create'])) ? $permissions['manager.create'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['manager.create']) && in_array($permissions['manager.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['manager.edit'])) ? $permissions['manager.edit'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['manager.edit']) && in_array($permissions['manager.edit'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">Edit </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['manager.delete'])) ? $permissions['manager.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['manager.delete']) && in_array($permissions['manager.delete'], $role_permissions)) ? 'checked' : '' }}>

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pathologists'])) ? $permissions['pathologists'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['pathologists']) && in_array($permissions['pathologists'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pathologist.create'])) ? $permissions['pathologist.create'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['pathologist.create']) && in_array($permissions['pathologist.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pathologist.edit'])) ? $permissions['pathologist.edit'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['pathologist.edit']) && in_array($permissions['pathologist.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['pathologist.delete'])) ? $permissions['pathologist.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['pathologist.delete']) && in_array($permissions['pathologist.delete'], $role_permissions)) ? 'checked' : '' }}>

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
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['lab_technician'])) ? $permissions['lab_technician'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['lab_technician']) && in_array($permissions['lab_technician'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['lab_technician.create'])) ? $permissions['lab_technician.create'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['lab_technician.create']) && in_array($permissions['lab_technician.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['lab_technician.edit'])) ? $permissions['lab_technician.edit'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['lab_technician.edit']) && in_array($permissions['lab_technician.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['lab_technician.delete'])) ? $permissions['lab_technician.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['lab_technician.delete']) && in_array($permissions['lab_technician.delete'], $role_permissions)) ? 'checked' : '' }}>

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['package'])) ? $permissions['package'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['package']) && in_array($permissions['package'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['package.create'])) ? $permissions['package.create'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['package.create']) && in_array($permissions['package.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['package.edit'])) ? $permissions['package.edit'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['package.edit']) && in_array($permissions['package.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['package.delete'])) ? $permissions['package.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['package.delete']) && in_array($permissions['package.delete'], $role_permissions)) ? 'checked' : '' }}>

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
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['camp'])) ? $permissions['camp'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['camp']) && in_array($permissions['camp'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['camp.create'])) ? $permissions['camp.create'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['camp.create']) && in_array($permissions['camp.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['camp.edit'])) ? $permissions['camp.edit'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['camp.edit']) && in_array($permissions['camp.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['camp.delete'])) ? $permissions['camp.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['camp.delete']) && in_array($permissions['camp.delete'], $role_permissions)) ? 'checked' : '' }}>

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['patient'])) ? $permissions['patient'] : '' }}" name="permissions[]"
                                                                 {{ (isset($permissions['patient']) && in_array($permissions['patient'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['patient.create'])) ? $permissions['patient.create'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['patient.create']) && in_array($permissions['patient.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['patient.edit'])) ? $permissions['patient.edit'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['patient.edit']) && in_array($permissions['patient.edit'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">Edit </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['patient.delete'])) ? $permissions['patient.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['patient.delete']) && in_array($permissions['patient.delete'], $role_permissions)) ? 'checked' : '' }}>

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['revenue'])) ? $permissions['revenue'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['revenue']) && in_array($permissions['revenue'], $role_permissions)) ? 'checked' : '' }}>

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
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['billing'])) ? $permissions['billing'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['billing']) && in_array($permissions['billing'], $role_permissions)) ? 'checked' : '' }}>
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
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['qc_report'])) ? $permissions['qc_report'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['qc_report']) && in_array($permissions['qc_report'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>


                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['qc_report.delete'])) ? $permissions['qc_report.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['qc_report.delete']) && in_array($permissions['qc_report.delete'], $role_permissions)) ? 'checked' : '' }}>

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test'])) ? $permissions['test'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['test']) && in_array($permissions['test'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.create'])) ? $permissions['test.create'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['test.create']) && in_array($permissions['test.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.edit'])) ? $permissions['test.edit'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['test.edit']) && in_array($permissions['test.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.delete'])) ? $permissions['test.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['test.delete']) && in_array($permissions['test.delete'], $role_permissions)) ? 'checked' : '' }}>

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

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['satellite_data'])) ? $permissions['satellite_data'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['satellite_data']) && in_array($permissions['satellite_data'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['satellite_data.delete'])) ? $permissions['satellite_data.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['satellite_data.delete']) && in_array($permissions['satellite_data.delete'], $role_permissions)) ? 'checked' : '' }}>

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
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device'])) ? $permissions['device'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['device']) && in_array($permissions['device'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                         <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.create'])) ? $permissions['device.create'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['device.create']) && in_array($permissions['device.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.edit'])) ? $permissions['device.edit'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['device.edit']) && in_array($permissions['device.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                         <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.delete'])) ? $permissions['device.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['device.delete']) && in_array($permissions['device.delete'], $role_permissions)) ? 'checked' : '' }}>

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
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.category'])) ? $permissions['device.category'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['device.category']) && in_array($permissions['device.category'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.category.create'])) ? $permissions['device.category.create'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['device.category.create']) && in_array($permissions['device.category.create'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.category.edit'])) ? $permissions['device.category.edit'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['device.category.edit']) && in_array($permissions['device.category.edit'], $role_permissions)) ? 'checked' : '' }}>

                                                                <span class="form-check-label">Edit </span>

                                                            </label>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <label class="form-check">

                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['device.category.delete'])) ? $permissions['device.category.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['device.category.delete']) && in_array($permissions['device.category.delete'], $role_permissions)) ? 'checked' : '' }}>

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
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['department'])) ? $permissions['department'] : '' }}" name="permissions[]"{{ (isset($permissions['department']) && in_array($permissions['department'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['department.create'])) ? $permissions['department.create'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['department.create']) && in_array($permissions['department.create'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['department.delete'])) ? $permissions['department.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['department.delete']) && in_array($permissions['department.delete'], $role_permissions)) ? 'checked' : '' }}>
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
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['patient.report'])) ? $permissions['patient.report'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['patient.report']) && in_array($permissions['patient.report'], $role_permissions)) ? 'checked' : '' }}>
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
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.profile'])) ? $permissions['test.profile'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['test.profile']) && in_array($permissions['test.profile'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.sub-profile.create'])) ? $permissions['test.sub-profile.create'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['test.sub-profile.create']) && in_array($permissions['test.sub-profile.create'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.sub-profile.delete'])) ? $permissions['test.sub-profile.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['test.sub-profile.delete']) && in_array($permissions['test.sub-profile.delete'], $role_permissions)) ? 'checked' : '' }}>
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
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.sub-profile'])) ? $permissions['test.sub-profile'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['test.sub-profile']) && in_array($permissions['test.sub-profile'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">List </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.sub-profile.create'])) ? $permissions['test.sub-profile.create'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['test.sub-profile.create']) && in_array($permissions['test.sub-profile.create'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">Create </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ (isset($permissions['test.sub-profile.delete'])) ? $permissions['test.sub-profile.delete'] : '' }}" name="permissions[]"
                                                                {{ (isset($permissions['test.sub-profile.delete']) && in_array($permissions['test.sub-profile.delete'], $role_permissions)) ? 'checked' : '' }}>
                                                                <span class="form-check-label">Delete </span>
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

                                    <button type="submit" class="btn btn-success">Update</button>

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

