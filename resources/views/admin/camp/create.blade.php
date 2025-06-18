@extends('admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

@php
    $today = date('Y-m-d');
@endphp

<section class="section store-form camps mt-3">
    <form action="{{ route('admin.camp.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="form-title d-flex">
                <i class="bi bi-person-fill"></i>
                <h5 class="ps-2 font-weight-bold">CAMP DETAIL</h5>
            </div>
        </div>
        <hr>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Camp/Static Lab<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="camp_name" class="form-control {{ $errors->has('camp_name') ? 'is-invalid' : '' }}" placeholder="Camp Name">
                        @if($errors->has('camp_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('camp_name') }}
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
                            <option value="">Select Org. Name</option>
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
                        <label class="form-label">Start Date <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                         <input type="date" name="camp_start_date" class="form-control {{ $errors->has('camp_start_date') ? 'is-invalid' : '' }}">
                        @if($errors->has('camp_start_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('camp_start_date') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">End Date <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="date" name="camp_end_date" class="form-control {{ $errors->has('camp_end_date') ? 'is-invalid' : '' }}">
                        @if($errors->has('camp_end_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('camp_end_date') }}
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
                        <label class="form-label">Pathologist <span class="text-danger">*</span></label>
                    </div>
                    <!-- pathologist_id -->
                    <div class="col-md-9">
                        <select name="pathologist" id="pathologist" class="form-control {{ $errors->has('pathologist') ? 'is-invalid' : '' }}">
                            <option value="">Select Pathologist</option>
                            @foreach ($pathologists as $pathologist)
                                <option value="{{ $pathologist->id }}">{{ $pathologist->username }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('pathologist'))
                            <div class="invalid-feedback">
                                {{ $errors->first('pathologist') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Lab Technician<span class="text-danger">*</span></label>
                    </div>

                    <!-- lab_technician_id -->
                    <div class="col-md-9">
                         <select name="lab_technician[]" id="lab_technician" class="form-control {{ $errors->has('lab_technician') ? 'is-invalid' : '' }}" multiple>
                            <option value="">Select Lab Technician</option>
                            @foreach ($lab_technicians as $lab_technician)
                                <option value="{{ $lab_technician->user_id }}">{{ $lab_technician->username }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('lab_technician'))
                            <div class="invalid-feedback">
                                {{ $errors->first('lab_technician') }}
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
                        <label class="form-label">Package <span class="text-danger">*</span></label>
                    </div>
                    <!-- package_id -->
                    <div class="col-md-9">
                        <select name="package" id="package" class="form-control {{ $errors->has('package') ? 'is-invalid' : '' }}">
                            <option value="">Select Package</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('package'))
                            <div class="invalid-feedback">
                                {{ $errors->first('package') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Lab UID<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <select name="associated_device_id" id="associated_device_id" class="form-control {{ $errors->has('associated_device_id') ? 'is-invalid' : '' }}">
                            <option value="">Select Lab UID</option>
                        </select>
                        @if($errors->has('associated_device_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('associated_device_id') }}
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
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                       <textarea name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"></textarea>
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- ----------------------- ADDRESS ---------------------- -->
        <div class="row mt-5">
            <div class="form-title d-flex">
                <i class="bi bi-person-fill"></i>
                <h5 class="ps-2 font-weight-bold">ADDRESS</h5>
            </div>
        </div>
        <hr>
    
        <div class="row mt-5">
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

        <!-- --------------------------Send Report------------------- -->
        <div class="row mt-5">
            <div class="form-title d-flex">
                <i class="bi bi-person-fill"></i>
                <h5 class="ps-2 font-weight-bold">Send Report</h5>
            </div>
        </div>
        <hr>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">To<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="to_email" class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" placeholder="To">
                        @if($errors->has('to_email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('to_email') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">CC <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="cc_email" class="form-control {{ $errors->has('cc_email') ? 'is-invalid' : '' }}" placeholder="CC">
                        @if($errors->has('cc_email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('cc_email') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- -------------------------- Header/ Footer ------------------- -->
        <div class="row mt-5">
            <div class="form-title d-flex">
                <i class="bi bi-person-fill"></i>
                <h5 class="ps-2 font-weight-bold">Header/ Footer</h5>
            </div>
        </div>
        <hr>

        <!-- header image -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">Header</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <label class="form-check-label ms-2" for="report_header_status">ON/OFF</label>
                            <input name="report_header_status" class="form-check-input m-0" type="checkbox" role="switch" id="report_header_status" value="1" checked>
                        </div>
                    </div>
                    <div class="col-md-7 d-flex mr-3">
                        <label class="form-label d-block size-of-image me-3">(2488 px X 450-600 px)</label>
                        <input type="file" name="report_header_image" id="report_header_input" title="Upload Image"
                            class="camp-header-image {{ $errors->has('report_header_image') ? 'is-invalid' : '' }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-9">
                        <div class="header-image">
                            <img src="" alt="" id="preview_report_header_image" class="mt-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <!-- footer image -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">Footer</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <label class="form-check-label ms-2" for="report_footer_status">ON/OFF</label>
                            <input name="report_footer_status" class="form-check-input m-0" type="checkbox" role="switch" id="report_footer_status" value="1" checked>
                        </div>
                    </div>
                   
                    <div class="col-md-7 d-flex mr-3">
                        <label class="form-label d-block size-of-image me-3">(2488 px X 450-600 px)</label>
                        <input type="file" name="report_footer_image" id="report_footer_input" title="Upload Image"
                            class="camp-footer-image {{ $errors->has('report_footer_image') ? 'is-invalid' : '' }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-9">
                        <div class="header-image">
                            <img src="" alt="" id="preview_report_footer_image" class="mt-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mb-3 mt-5">
            <a href="{{ route('admin.camp') }}" type="button" class="btn btn-danger me-2">Cancel</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>

    </form>
</section>
@endsection

@section('custom-js')
<script>
    $(document).ready(function() {
        $('#lab_technician').select2();
    });

    $(document).ready(function () {
        $('#organization_type').change(function () {
            let orgId = $(this).val();
            let $deviceDropdown = $('#associated_device_id');
            $deviceDropdown.empty().append('<option value="">Loading...</option>');

            if (orgId) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.organization.devices') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'organization_id': orgId,
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        $deviceDropdown.empty().append('<option value="">Select Lab UID</option>');
                        $.each(data, function (key, device) {
                            $deviceDropdown.append('<option value="' + device.id + '">' + device.device_code + '</option>');
                        });
                    },
                    error: function () {
                        $deviceDropdown.empty().append('<option value="">Failed to load</option>');
                    }
                });
            } else {
                $deviceDropdown.empty().append('<option value="">Select Lab UID</option>');
            }
        });
    });

    $('#report_header_input').on('change', function () {
        const file = this.files[0];

        if (file) {
            const img = new Image();
            const objectUrl = URL.createObjectURL(file);

            img.onload = function () {
                const width = img.naturalWidth;
                const height = img.naturalHeight;
                    // 400 x 97
                // if (width === 402 && height === 82) {
                if (width === 400 && height === 80) {
                    $('#preview_report_header_image').attr('src', objectUrl);
                } else {
                    alert("Image must be exactly 2488px wide and between 450px to 600px tall.");
                    $('#report_header_input').val('');
                    $('#preview_report_header_image').attr('src', '');
                }

                URL.revokeObjectURL(objectUrl);
            };

            img.src = objectUrl;
        } else {
            $('#preview_report_header_image').attr('src', '');
        }
    });

    $('#report_footer_input').on('change', function () {
        const file = this.files[0];

        if (file) {
            const img = new Image();
            const objectUrl = URL.createObjectURL(file);

            img.onload = function () {
                const width = img.naturalWidth;
                const height = img.naturalHeight;

                // 400 x 73
                // if (width === 402 && height === 82) {
                if (width === 402 && height === 51) {
                    $('#preview_report_footer_image').attr('src', objectUrl);
                } else {
                    alert("Footer image must be exactly 2488px wide and between 450px to 600px tall.");
                    $('#report_footer_input').val('');
                    $('#preview_report_footer_image').attr('src', '');
                }

                URL.revokeObjectURL(objectUrl);
            };

            img.src = objectUrl;
        } else {
            $('#preview_report_footer_image').attr('src', '');
        }
    });
</script>
@endsection