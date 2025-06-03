@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

@php
    $today = date('Y-m-d');
@endphp

<section class="section store-form devices mt-3">
    <form action="{{ route('device.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="device_id" value="{{ encrypt($device->id) }}">
        <div class="row">
            <div class="form-title d-flex">
                <i class="bi bi-person-fill"></i>
                <h5 class="ps-2 font-weight-bold">DEVICE DETAIL</h5>
            </div>
        </div>
        <hr>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                            <select name="device_name" class="form-select {{ $errors->has('device_name') ? 'is-invalid' : '' }}">
                                <option value="">select Category</option>
                                @foreach ($device_categories as $device_categorie)
                                    <option value="{{ $device_categorie->id }}" {{ $device->device_code == $device_categorie->device_code ? 'selected' : '' }}>{{ $device_categorie->device_name }}</option>
                                @endforeach
                            </select>
                        @if($errors->has('device_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('device_name') }}
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
                                <option value="{{ $organization->id }}" {{ $device->organization_id == $organization->id ? 'selected' : '' }}>{{ $organization->organization_name }}</option>
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
                        <label class="form-label">UID <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="device_code" value="{{ $device->device_code }}" class="form-control {{ $errors->has('device_code') ? 'is-invalid' : '' }}" placeholder="LAB9999AHXXXX">
                        @if($errors->has('device_code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('device_code') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Product Details<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="device_detail" value="{{ $device->notes }}" class="form-control {{ $errors->has('device_detail') ? 'is-invalid' : '' }}" placeholder="Product Details">
                        @if($errors->has('device_detail'))
                            <div class="invalid-feedback">
                                {{ $errors->first('device_detail') }}
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
                        <label class="form-label">Lab S.N. <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="device_serial" value="{{ $device->device_serial }}" class="form-control {{ $errors->has('device_serial') ? 'is-invalid' : '' }}" placeholder="ACC/ML/XXXXX">
                        @if($errors->has('device_serial'))
                            <div class="invalid-feedback">
                                {{ $errors->first('device_serial') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                </div>
            </div>
        </div>

        <!-- BUTTONS -->
        <div class="text-center mb-3 mt-5">
            <a href="{{ route('device') }}" type="button" class="btn btn-danger me-2">Cancel</a>
            <button type="submit" class="btn btn-success">Update</button>
        </div>

    </form>
</section>
@endsection

@section('custom-js')
<script>

</script>
@endsection