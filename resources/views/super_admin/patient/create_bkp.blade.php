@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

@php
    $today = date('Y-m-d');
@endphp

<section class="section store-form patients mt-3">
    <form action="{{ route('patient.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="form-title d-flex">
                <i class="bi bi-person-fill"></i>
                <h5 class="ps-2 font-weight-bold">PATIENT DETAIL</h5>
            </div>
        </div>
        <hr>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Camp<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <select name="camp_name" id="camp_name" class="form-control {{ $errors->has('camp_name') ? 'is-invalid' : '' }}" value="{{old('camp_name')}}">
                            <option value="">Select Camp</option>
                            @foreach ($camps as $camp)
                                <option value="{{ $camp->id }}">{{ $camp->camp_name }}</option>
                            @endforeach
                        </select>
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
                        <label class="form-label">Email<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="email" placeholder="Enter Email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{old('email')}}">
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
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
                        <label class="form-label">Name<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                         <input type="text" name="username" placeholder="Enter Name" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" value="{{old('username')}}">
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
                        <label class="form-label">ID Card <span class="text-danger">*</span></label>
                    </div>
                    <!-- 'passport','driver_license','national_id','other' -->
                    <div class="col-md-4">
                        <select name="identity_proof_type" id="identity_proof_type" class="form-control {{ $errors->has('identity_proof_type') ? 'is-invalid' : '' }}">
                            <option value="">Select</option>
                            <option value="passport">passport</option>
                            <option value="driver_license">driver_license</option>
                            <option value="national_id">national_id</option>
                            <option value="other">other</option>
                        </select>
                        @if($errors->has('identity_proof_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('identity_proof_type') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-5">
                        <input name="identity_proof_number" type="text" placeholder="999999999999999" class="form-control {{ $errors->has('identity_proof_number') ? 'is-invalid' : '' }}" value="{{old('identity_proof_number')}}">
                        @if($errors->has('identity_proof_number'))
                            <div class="invalid-feedback">
                                {{ $errors->first('identity_proof_number') }}
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
                        <label class="form-label">Age <span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-md-9">
                        <input type="number" placeholder="Age" name="age" class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}" value="{{old('age')}}">
                        @if($errors->has('age'))
                            <div class="invalid-feedback">
                                {{ $errors->first('age') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Gender<span class="text-danger">*</span></label>
                    </div>

                    <!-- lab_technician_id -->
                    <div class="col-md-9">
                         <select name="gender" id="gender" class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">other</option>
                        </select>
                        @if($errors->has('gender'))
                            <div class="invalid-feedback">
                                {{ $errors->first('gender') }}
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
                        <label class="form-label">Reference By</label>
                    </div>
                  
                    <div class="col-md-9">
                        <input type="text" name="refrance_by" class="form-control {{ $errors->has('refrance_by') ? 'is-invalid' : '' }}" placeholder="Reference By" value="{{old('refrance_by')}}">
                        @if($errors->has('refrance_by'))
                            <div class="invalid-feedback">
                                {{ $errors->first('refrance_by') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Contact<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="number" name="mobile_number" placeholder="Mobile no." class="form-control {{ $errors->has('mobile_number') ? 'is-invalid' : '' }}" value="{{old('mobile_number')}}">
                        @if($errors->has('mobile_number'))
                            <div class="invalid-feedback">
                                {{ $errors->first('mobile_number') }}
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
        </div>
    
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" placeholder="Address" value="{{old('address')}}">
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
                        <label class="form-label">History <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="medical_history" class="form-control {{ $errors->has('medical_history') ? 'is-invalid' : '' }}" placeholder="Medical History" value="{{old('medical_history')}}">
                        @if($errors->has('medical_history'))
                            <div class="invalid-feedback">
                                {{ $errors->first('medical_history') }}
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
                        <label class="form-label">Profile<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <select name="profile" id="profile" class="form-control {{ $errors->has('profile') ? 'is-invalid' : '' }}">
                                <option value="">Select Profile</option>
                            @foreach ($test_profiles as $test_profile)
                                <option value="{{ $test_profile->id }}">{{ $test_profile->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('profile'))
                            <div class="invalid-feedback">
                                {{ $errors->first('profile') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Test <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <select name="test_list[]" id="test_list" class="form-control {{ $errors->has('test_list') ? 'is-invalid' : '' }}" multiple>
                            @foreach ($tests as $test)
                                <option value="{{ $test->id }}">{{ $test->test_name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('test_list'))
                            <div class="invalid-feedback">
                                {{ $errors->first('test_list') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mb-3 mt-5">
            <a href="{{ route('patient') }}" type="button" class="btn btn-danger me-2">Cancel</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendOtpModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="sendOtpModal" tabindex="-1" aria-labelledby="sendOtpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="otp-content">
                        <p class="mb-0">OTP sent to your mobile no.</p>
                        <p class="mb-0">ending with xxxxxx4995</p>
                    </div>

                    <div class="row otp-section" style="justify-content: center;">
                        <dic class="col-md-4 px-1">
                            <input type="text" name="otp" id="otpInput" class="form-control" placeholder="Enter OTP">
                        </dic>
                        <dic class="col-md-2 ps-0">
                            <button class="btn btn-primary" id="resendBtn" onclick="startResendTimer()">Submit</button>
                        </dic>

                        <p id="timer"></p>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>


    <style>
        #sendOtpModal .otp-content {
            text-align: center;
            margin-bottom: 30px;
        }
        .otp-content p {
            margin-bottom: 0;
            color: green;
            font-size: 18px;
            font-weight: 400;
        }
        .otp-section button {
            background: #009F28;
            border: none;
            font-weight: 600;
        }
        .otp-section #timer {
            text-align: center;
            margin-top: 10px;
            font-size: 15px;
            font-weight: 700;
        }
    </style>

</section>
@endsection

@section('custom-js')
<script>
    $(document).ready(function () {
       $('#test_list').select2();
    });

    $('#profile').on('change', function () {
        let profileId = $(this).val();
        $('#test_list').empty().append('<option value="">Select Test</option>');
        testListLocked = false;

        if (profileId) {
            $.ajax({
                    type: "POST",
                    url: '{{ route("lab_technician.tests.profiles") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'profile_id': profileId,
                    },
                    dataType: 'JSON',
                    success: function(response)
                    {
                        if (response.success == 1 && response.data.length > 0) {
                            $.each(response.data, function (index, test) {
                                $('#test_list').append(`<option value="${test.id}" selected>${test.test_name}</option>`);
                            });

                            $('#test_list').trigger('change');
                            testListLocked = true;
                        }
                    },
                    error: function () {
                        alert('Failed to fetch tests.');
                    }
                });
        }
    });

    $('#test_list').on('select2:opening select2:unselecting', function (e) {
        if (testListLocked) {
            e.preventDefault();
        }
    });
</script>

<script>
    let timer;
    let countdown = 60; // Set the countdown duration in seconds

    function startResendTimer() {
        // Disable the button during the countdown
        document.getElementById('resendBtn').disabled = true;

        // Start the countdown
        timer = setInterval(updateTimer, 1000);
    }

    function updateTimer() {
        const timerElement = document.getElementById('timer');
        
        if (countdown > 0) {
            timerElement.textContent = `Resend in ${countdown} seconds`;
            countdown--;
        } else {
            document.getElementById('resendBtn').disabled = false;
            timerElement.textContent = '';
            
            countdown = 60;
            clearInterval(timer);
        }
    }

    // check otp resend button
    $('#resendBtn').on('click', function () {
        let mobile = $('input[name="mobile_number"]').val();
        if (!mobile) {
            alert('Please enter mobile number first.');
            return;
        }

        $.post('{{ route("otp.send") }}', {
            mobile_number: mobile,
            _token: '{{ csrf_token() }}'
        }, function (res) {
            if (res.success) {
                alert('OTP sent!');
                startResendTimer();
            } else {
                alert(res.message);
            }
        });
    });

    $('#otpInput').on('change', function () {
        const otp = $(this).val();
        const mobile = $('input[name="mobile_number"]').val();

        $.post('{{ route("otp.verify") }}', {
            mobile_number: mobile,
            otp: otp,
            _token: '{{ csrf_token() }}'
        }, function (res) {
            if (res.success) {
                alert('OTP Verified!');
            } else {
                alert(res.message);
            }
        });
    });
</script>

@endsection