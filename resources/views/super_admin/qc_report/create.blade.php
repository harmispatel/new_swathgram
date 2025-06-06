@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

@php
    $today = date('Y-m-d');
@endphp

<section class="section store-form lab_technicians mt-3">
    <form action="{{ route('lab_technician.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="form-title d-flex">
                <i class="bi bi-person-fill"></i>
                <h5 class="ps-2 font-weight-bold">LAB TECHNICIANS DETAIL</h5>
            </div>
        </div>
        <hr>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Name">
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Organization<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <select id="organization_type" class="form-select {{ $errors->has('organization_type') ? 'is-invalid' : '' }}" name="organization_type">
                            @foreach ($organizations as $organization)
                                <option value="{{ $organization->id }}">{{ $organization->organization_name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('organization_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('organization_type') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Gender <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <select name="gender" class="form-select {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                            <option value="male">Male</option>
                          <option value="female">Female</option>
                        </select>
                        @if($errors->has('gender'))
                            <div class="invalid-feedback">
                                {{ $errors->first('gender') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">DOB <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="date" name="dob" class="form-control {{ $errors->has('dob') ? 'is-invalid' : '' }}" max="{{ $today }}">
                        @if($errors->has('dob'))
                            <div class="invalid-feedback">
                                {{ $errors->first('dob') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Email">
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Profile Image <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="file" name="photo" class="form-control {{ $errors->has('photo') ? 'is-invalid' : '' }}">
                        @if($errors->has('photo'))
                            <div class="invalid-feedback">
                                {{ $errors->first('photo') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Contact <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="contact" class="form-control {{ $errors->has('contact') ? 'is-invalid' : '' }}" placeholder="Contact">
                        @if($errors->has('contact'))
                            <div class="invalid-feedback">
                                {{ $errors->first('contact') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">License<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="file" name="license" class="form-control {{ $errors->has('license') ? 'is-invalid' : '' }}">
                        @if($errors->has('license'))
                            <div class="invalid-feedback">
                                {{ $errors->first('license') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Signature <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="file" name="signature" class="form-control {{ $errors->has('signature') ? 'is-invalid' : '' }}">
                        @if($errors->has('signature'))
                            <div class="invalid-feedback">
                                {{ $errors->first('signature') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Certificate<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="file" name="certificate" class="form-control {{ $errors->has('certificate') ? 'is-invalid' : '' }}">
                        @if($errors->has('certificate'))
                            <div class="invalid-feedback">
                                {{ $errors->first('certificate') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- --------------------------------------------- -->
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="form-title d-flex">
                    <i class="bi bi-person-fill"></i>
                    <h5 class="ps-2 font-weight-bold">SECURITY</h5>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-title d-flex">
                    <i class="bi bi-person-fill"></i>
                    <h5 class="ps-2 font-weight-bold">ADDRESS</h5>
                </div>
            </div>
        </div>
        <hr>
    

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" placeholder="Username">
                        @if($errors->has('username'))
                            <div class="invalid-feedback">
                                {{ $errors->first('username') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="address" class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" placeholder="Address">
                        @if($errors->has('address'))
                            <div class="invalid-feedback">
                                {{ $errors->first('address') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Password">
                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">State <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="state" class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" placeholder="State">
                        @if($errors->has('state'))
                            <div class="invalid-feedback">
                                {{ $errors->first('state') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Re- Password<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="password" name="confirm_password" class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" placeholder="confirm_password">
                        @if($errors->has('confirm_password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('confirm_password') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">City<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="city" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" placeholder="city">
                        @if($errors->has('city'))
                            <div class="invalid-feedback">
                                {{ $errors->first('city') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="row">
                   
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">pincode <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="pincode" class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" placeholder="Pincode">
                        @if($errors->has('pincode'))
                            <div class="invalid-feedback">
                                {{ $errors->first('pincode') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- BUTTONS -->
        <div class="text-center mb-3 mt-5">
            <a href="{{ route('lab_technician') }}" type="button" class="btn btn-danger me-2">Cancel</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>

    </form>
</section>
@endsection

@section('custom-js')
<script>
$(document).ready(function() {
    $('#organization_type').select2();
});
</script>
@endsection