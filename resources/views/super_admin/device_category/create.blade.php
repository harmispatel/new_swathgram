@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

@php
    $today = date('Y-m-d');
@endphp

<section class="section store-form devices mt-3">
    <form action="{{ route('device.category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="form-title d-flex">
                <i class="bi bi-person-fill"></i>
                <h5 class="ps-2 font-weight-bold">DEVICE CATEGORY DETAIL</h5>
            </div>
            <div class="warning">
                <p class="text-danger">
                    Warning : This form is only for registering or impaneling new innovations by Accuster. It should not be used for adding existing products.
                </p>
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
                        <input type="text" name="device_name" placeholder="Enter Name" value="{{old('device_name')}}">
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
                        <input type="text" name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" placeholder="Product Details" value="{{old('description')}}">
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
            <button type="submit" class="btn btn-success">Save</button>
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