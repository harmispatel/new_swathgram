@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

@php
    $today = date('Y-m-d');
@endphp

<section class="section store-form devices mt-3">
    <form action="{{ route('device.category.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="category_id" value="{{ encrypt($device_category->id) }}">
        <div class="row">
            <div class="form-title d-flex">
                <i class="bi bi-person-fill"></i>
                <h5 class="ps-2 font-weight-bold">DEVICE CATEGORY DETAIL</h5>
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
                        <input type="text" name="device_name" value="{{ $device_category->device_name }}">
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
                        <label class="form-label">Product Details<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="description" value="{{ $device_category->description }}" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" placeholder="Product Details">
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mb-3 mt-5">
            <a href="{{ route('device.category') }}" type="button" class="btn btn-danger me-2">Cancel</a>
            <button type="submit" class="btn btn-success">Update</button>
        </div>

    </form>
</section>
@endsection

@section('custom-js')
<script>
$(document).ready(function() {
  //  $('#organization_type').select2();
});
</script>
@endsection