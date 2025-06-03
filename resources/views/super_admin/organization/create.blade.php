@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section store-form organization mt-3">
    <form action="{{ route('organization.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="form-title d-flex">
                <i class="bi bi-person-fill"></i>
                <h5 class="ps-2 font-weight-bold">ORGANIZATION DETAIL</h5>
            </div>
        </div>
        <hr>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Org. Name <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="organization_name" class="form-control {{ $errors->has('organization_name') ? 'is-invalid' : '' }}" placeholder="Name">
                        @if($errors->has('organization_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('organization_name') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Owner Name <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="owner_name" class="form-control {{ $errors->has('owner_name') ? 'is-invalid' : '' }}" placeholder="Enter Owner Name">
                        @if($errors->has('owner_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('owner_name') }}
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
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Revenue <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <select name="revenue_type" class="form-select {{ $errors->has('revenue_type') ? 'is-invalid' : '' }}">
                            <option value="">Revenue Type</option>
                            <option value="amount">Amount</option>
                            <option value="personteg">% Persontege</option>
                        </select>
                        @if($errors->has('revenue_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('revenue_type') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Revenue Share<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="number" name="revenue_share" class="form-control {{ $errors->has('revenue_share') ? 'is-invalid' : '' }}" placeholder="Revenue Share">
                        @if($errors->has('revenue_share'))
                            <div class="invalid-feedback">
                                {{ $errors->first('revenue_share') }}
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
                        <label class="form-label">Org. Info <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="org_info" class="form-control {{ $errors->has('org_info') ? 'is-invalid' : '' }}" placeholder="Org. Information">
                        @if($errors->has('org_info'))
                            <div class="invalid-feedback">
                                {{ $errors->first('org_info') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Org. GST / PAN</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="gst_pan_number" class="form-control {{ $errors->has('gst_pan_number') ? 'is-invalid' : '' }}" placeholder="Org. GST / PAN">
                        @if($errors->has('gst_pan_number'))
                            <div class="invalid-feedback">
                                {{ $errors->first('gst_pan_number') }}
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
                        <label class="form-label">Org. CIN</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="org_cin" class="form-control {{ $errors->has('org_cin') ? 'is-invalid' : '' }}" placeholder="Org. CIN">
                        @if($errors->has('org_cin'))
                            <div class="invalid-feedback">
                                {{ $errors->first('org_cin') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Org. Logo</label>
                    </div>
                    <div class="col-md-9">
                        <input type="file" name="org_logo" class="form-control {{ $errors->has('org_logo') ? 'is-invalid' : '' }}">
                        @if($errors->has('org_logo'))
                            <div class="invalid-feedback">
                                {{ $errors->first('org_logo') }}
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
                        <label class="form-label">Apps <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="app_selection" type="checkbox" value="0" id="ltApp" checked>
                            <label class="form-check-label" for="ltApp">LT app</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="app_selection" type="checkbox" value="1" id="microscopeApp">
                            <label class="form-check-label" for="microscopeApp">Microscope app</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="app_selection" type="checkbox" value="2" id="urineApp">
                            <label class="form-check-label" for="urineApp">Urine app</label>
                        </div>
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
                        <label class="form-label">Country <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="country" class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" placeholder="Country">
                        @if($errors->has('country'))
                            <div class="invalid-feedback">
                                {{ $errors->first('country') }}
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
                        <label class="form-label">Pincode <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="number" name="pincode" class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" placeholder="Pincode">
                        @if($errors->has('pincode'))
                            <div class="invalid-feedback">
                                {{ $errors->first('pincode') }}
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
                        <label class="form-label">Premium </label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-check">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="premium" value="1" id="premiumYes" checked>
                                <label class="form-check-label" for="premiumYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="premium" value="0" id="premiumNo">
                                <label class="form-check-label" for="premiumNo">NO</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">OTP Authentication</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-check">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="otp_authentication" value="1" id="otpYes">
                                <label class="form-check-label" for="otpYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="otp_authentication" value="0" id="otpNo" checked>
                                <label class="form-check-label" for="otpNo">NO</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BUTTONS -->
        <div class="text-center mb-3 mt-5">
            <a href="{{ route('organization') }}" type="button" class="btn btn-danger me-2">Cancel</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>

    </form>
</section>
@endsection

@section('custom-js')
<script>
</script>
@endsection