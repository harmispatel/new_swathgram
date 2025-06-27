@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

@php
    $today = date('Y-m-d');
@endphp

<section class="section tests mt-3">
    <div class="container">
        <form action="{{ route('test.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="form-title d-flex">
                    <i class="bi bi-person-fill"></i>
                    <h5 class="ps-2 font-weight-bold">TEST DETAIL</h5>
                </div>
            </div>
            <hr>

            <div class="row mt-5">
                <div class="col-md-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="test_name" class="form-control {{ $errors->has('test_name') ? 'is-invalid' : '' }}" placeholder="Test Name" value="{{old('test_name')}}">
                    @if($errors->has('test_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('test_name') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Test Code <span class="text-danger">*</span></label>
                            <input type="text" name="test_code" class="form-control {{ $errors->has('test_code') ? 'is-invalid' : '' }}" placeholder="Test Code" value="{{old('test_code')}}">
                            @if($errors->has('test_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('test_code') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Test Unit <span class="text-danger">*</span></label>
                            <input type="text" name="unit" class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" placeholder="Test Unit" value="{{old('unit')}}">
                            @if($errors->has('unit'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('unit') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">Department <span class="text-danger">*</span></label>
                    <select name="department" class="form-control {{ $errors->has('department') ? 'is-invalid' : '' }}">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('department'))
                        <div class="invalid-feedback">
                            {{ $errors->first('department') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Test Price <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" placeholder="Test Price" value="{{old('price')}}">
                            @if($errors->has('price'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('price') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Manual /Machine <span class="text-danger">*</span></label>
                            <select name="manual_machine" class="form-control {{ $errors->has('manual_machine') ? 'is-invalid' : '' }}">
                                <option value="">Select Result Mode</option>
                                <option value="manual"> Manual </option>
                                <option value="machine"> Machine </option>
                            </select>

                            @if($errors->has('manual_machine'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('manual_machine') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">Profile <span class="text-danger">*</span></label>
                    <select name="profile" class="form-control {{ $errors->has('profile') ? 'is-invalid' : '' }}">
                        <option value="">Select Profile</option>
                        @foreach ($profiles as $profile)
                            <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('profile'))
                        <div class="invalid-feedback">
                            {{ $errors->first('profile') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Image Permission <span class="text-danger">*</span></label>
                            <select name="image_permissions" class="form-control {{ $errors->has('image_permissions') ? 'is-invalid' : '' }}" id="">
                                <option value="">Yes/No</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @if($errors->has('image_permissions'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('image_permissions') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Test Action <span class="text-danger">*</span></label>
                            <select name="test_mode" class="form-control {{ $errors->has('test_mode') ? 'is-invalid' : '' }}">
                                <option value="">Static / Dynamic</option>
                                <option value="0">Static</option>
                                <option value="1">Dynamic</option>
                            </select>

                            @if($errors->has('test_mode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('test_mode') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


             <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">Sub Profile <span class="text-danger">*</span></label>
                    <select name="sub_profile" class="form-control {{ $errors->has('sub_profile') ? 'is-invalid' : '' }}">
                        <option value="">Select Sub Profile</option>
                        @foreach ($sub_profiles as $sub_profile)
                            <option value="{{ $sub_profile->id }}">{{ $sub_profile->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('sub_profile'))
                        <div class="invalid-feedback">
                            {{ $errors->first('sub_profile') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Test Serial Number <span class="text-danger">*</span></label>
                            <input type="text" name="test_serial_number" class="form-control {{ $errors->has('test_serial_number') ? 'is-invalid' : '' }}" placeholder="Serial Number" value="{{old('test_serial_number')}}">
                            @if($errors->has('test_serial_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('test_serial_number') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Test Method <span class="text-danger">*</span></label>
                            <input type="text" name="test_method" class="form-control {{ $errors->has('test_method') ? 'is-invalid' : '' }}" value="{{old('test_method')}}">

                            @if($errors->has('test_method'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('test_method') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- --------------------------------------------- -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="form-title d-flex">
                        <i class="bi bi-person-fill"></i>
                        <h5 class="ps-2 font-weight-bold">Bio. Reference</h5>
                    </div>
                </div>
            </div>
            <hr>
        
            <div class="row mt-5">
                <div class="col-md-6">
                    <label class="form-label">Bio ref. range (Male) <span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-md-4 pe-1">
                            <input type="number" name="male_lower_range" class="form-control {{ $errors->has('male_lower_range') ? 'is-invalid' : '' }}" placeholder="Lower Bound" value="{{old('male_lower_range')}}">
                            @if($errors->has('male_lower_range'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('male_lower_range') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 ps-1 pe-1">
                            <input type="number" name="male_upper_range" class="form-control {{ $errors->has('male_upper_range') ? 'is-invalid' : '' }}" placeholder="Upper Bound" value="{{old('male_upper_range')}}">
                            @if($errors->has('male_upper_range'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('male_upper_range') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 ps-1">
                            <input type="number" name="male_preview" class="form-control {{ $errors->has('male_preview') ? 'is-invalid' : '' }}" placeholder="Preview" value="{{old('male_preview')}}">
                            @if($errors->has('male_preview'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('male_preview') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bio ref. range (Child)<span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-md-4 pe-1">
                            <input type="number" name="child_lower_range" class="form-control {{ $errors->has('child_lower_range') ? 'is-invalid' : '' }}" placeholder="Lower Bound" value="{{old('child_lower_range')}}">
                            @if($errors->has('child_lower_range'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('child_lower_range') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 ps-1 pe-1">
                            <input type="number" name="child_upper_range" class="form-control {{ $errors->has('child_upper_range') ? 'is-invalid' : '' }}" placeholder="Upper Bound" value="{{old('child_upper_range')}}">
                            @if($errors->has('child_upper_range'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('child_upper_range') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 ps-1">
                            <input type="number" name="child_preview" class="form-control {{ $errors->has('child_preview') ? 'is-invalid' : '' }}" placeholder="Preview" value="{{old('child_preview')}}">
                            @if($errors->has('child_preview'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('child_preview') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-6">
                    <label class="form-label">Bio ref. range (Female)<span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-md-4 pe-1">
                            <input type="number" name="female_lower_range" class="form-control {{ $errors->has('female_lower_range') ? 'is-invalid' : '' }}" placeholder="Lower Bound" value="{{old('female_lower_range')}}">
                            @if($errors->has('female_lower_range'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('female_lower_range') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 ps-1 pe-1">
                            <input type="number" name="female_upper_range" class="form-control {{ $errors->has('female_upper_range') ? 'is-invalid' : '' }}" placeholder="Upper Bound" value="{{old('female_upper_range')}}">
                            @if($errors->has('female_upper_range'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('female_upper_range') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 ps-1">
                            <input type="number" name="female_preview" class="form-control {{ $errors->has('female_preview') ? 'is-invalid' : '' }}" placeholder="Preview" value="{{old('female_preview')}}">
                            @if($errors->has('female_preview'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('female_preview') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bio ref. range (Animal)<span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-md-4 pe-1">
                            <input type="number" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Lower Bound">
                        </div>
                        <div class="col-md-4 ps-1 pe-1">
                            <input type="number" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Upper Bound">
                        </div>
                        <div class="col-md-4 ps-1">
                            <input type="number" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Preview">
                        </div>
                    </div>
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="text-center mb-3 mt-5">
                <a href="{{ route('test') }}" type="button" class="btn btn-danger me-2">Cancel</a>
                <button type="submit" class="btn btn-success">Save</button>
            </div>

        </form>
    </div> 
</section>
@endsection

@section('custom-js')
<script>
$(document).ready(function() {
    $('#organization_type').select2();
});
</script>
@endsection