@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

@php
    $today = date('Y-m-d');
@endphp

<section class="section store-form package mt-3">
    <form action="{{ route('package.update') }}" id="package-form" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="package_id" value="{{ encrypt($package->id) }}">
        <div class="row">
            <div class="form-title d-flex">
                <i class="bi bi-person-fill"></i>
                <h5 class="ps-2 font-weight-bold">PACKAGE DETAIL</h5>
            </div>
        </div>
        <hr>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Package Name <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="package_name" value="{{ $package->package_name }}" class="form-control {{ $errors->has('package_name') ? 'is-invalid' : '' }}" placeholder="Package Name">
                        @if($errors->has('package_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('package_name') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Profile<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <select name="profile" id="profile" class="form-control {{ $errors->has('profile') ? 'is-invalid' : '' }}">
                            <option value="">Select Profile</option>    
                            @foreach ($test_profiles as $test_profile)
                                <option value="{{ $test_profile->id }}" {{ $package->profile_id == $test_profile->id ? 'selected' : '' }}>{{ $test_profile->name }}</option>
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
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Package Type <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <select name="package_type" id="package_type" class="form-control {{ $errors->has('package_type') ? 'is-invalid' : '' }}">
                            <option value="">Package Type</option>
                            <option value="free" {{ $package->package_type == 'free' ? 'selected' : '' }}>Free</option>
                            <option value="discounted" {{ $package->package_type == 'discounted' ? 'selected' : '' }}>Discounted</option>
                            <option value="paid" {{ $package->package_type == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                        @if($errors->has('package_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('package_type') }}
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
                            <option value="">Select Test</option>
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

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Organization<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <select id="organization_type" class="form-select {{ $errors->has('organization_type') ? 'is-invalid' : '' }}" name="organization_type[]" multiple="multiple">
                            @foreach ($organizations as $organization)
                                <option value="{{ $organization->id }}" {{ $package->organizations->contains('id', $organization->id) ? 'selected' : '' }}>{{ $organization->organization_name }}</option>
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
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Discount<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <select name="discounted_type" id="discounted_type" class="form-control {{ $errors->has('discounted_type') ? 'is-invalid' : '' }}"> 
                            <option value="">Select Discount Type</option>
                            <option value="amount" {{ $package->discounted_type == 'amount' ? 'selected' : '' }}>Amount</option>
                            <option value="percentage" {{ $package->discounted_type == 'percentage' ? 'selected' : '' }}>Percentage %</option>
                        </select>
                        @if($errors->has('discounted_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('discounted_type') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Discount Value<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="number" name="discounted_price" id="discounted_price" value="{{ $package->discounted_price }}" class="form-control {{ $errors->has('discounted_price') ? 'is-invalid' : '' }}" placeholder="Discounted Price">
                        @if($errors->has('discounted_price'))
                            <div class="invalid-feedback">
                                {{ $errors->first('discounted_price') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table package-view mt-5">
                    <thead>
                        <tr>
                            <th>Profile</th>
                            <th>Sub- Profile</th>
                            <th>Test Name</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="test_table_body">
                        @foreach($package->tests as $test)
                            <tr>
                                <td>{{ $test->testProfile->name ?? '-' }}</td>
                                <td>{{ $test->testSubprofile->name ?? '-' }}</td>
                                <td>{{ $test->test_name }}</td>
                                <td class="price">{{ $test->price }}</td>
                            </tr>
                            <input type="hidden" name="test_ids[]" value="{{ $test->id }}">
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total Price:</strong></td>
                            <td><strong id="total_price">0</strong>
                                <input type="hidden" name="price" id="price">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Discount:</strong></td>
                            <td><strong id="total_discount">0</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Final amount:</strong></td>
                            <td><strong id="final_amount">0</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- BUTTONS -->
        <div class="text-center mb-3 mt-5">
            <a href="{{ route('package') }}" type="button" class="btn btn-danger me-2">Cancel</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>

    </form>

    

</section>
@endsection

@section('custom-js')
<script>
    $(document).ready(function() {
        $('#organization_type').select2();
        $('#test_list').select2();
    });

    $('#profile').on('change', function () {
        let profileId = $(this).val();
        $('#test_list').empty().append('<option value="">Select Test</option>');

        if (profileId) {
            $.ajax({
                    type: "POST",
                    url: '{{ route("tests.profiles") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'profile_id': profileId,
                    },
                    dataType: 'JSON',
                    success: function(response)
                    {
                        if (response.success == 1 && response.data.length > 0) {
                            $.each(response.data, function (index, test) {
                                $('#test_list').append(`<option value="${test.id}">${test.test_name}</option>`);
                            });
                        }
                    },
                    error: function () {
                        alert('Failed to fetch tests.');
                    }
                });
        }
    });

    function calculateTotals()
    {
        let totalPrice = parseFloat($('#total_price').text()) || 0;
        let discountType = $('#discounted_type').val();
        let discountValue = parseFloat($('#discounted_price').val()) || 0;
        let discountAmount = 0;

        if (discountType === 'amount') {
            discountAmount = discountValue;
        } else if (discountType === 'percentage') {
            discountAmount = (discountValue / 100) * totalPrice;
        }

        let finalAmount = totalPrice - discountAmount;

        $('#total_discount').text(discountAmount.toFixed(2));
        $('#final_amount').text(finalAmount.toFixed(2));
        $('#price').val(totalPrice);
    }

    $('#package_type, #discounted_type, #discounted_price').on('change keyup', function () {
    
        const packageType = $('#package_type').val();
        if (packageType === 'paid') {
            $('#discounted_type').prop('disabled', false);
            $('#discounted_price').prop('disabled', false);
            calculateTotals();
        } else {
            $('#discounted_type').prop('disabled', true);
            $('#discounted_price').prop('disabled', true);
            $('#total_discount').text('0.00');
            $('#final_amount').text($('#total_price').text());
            $('#price').value($('#total_price').text());
        }
    });

    $('#test_list').on('change', function () {
        let testIds = $(this).val();

        $('#test_table_body').empty();

        if (testIds && testIds.length > 0) {
            $.ajax({
                type: "POST",
                url: '{{ route("test.details") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    test_ids: testIds,
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success === 1) {
                        let total = 0;

                        response.data.forEach(function (test) {
                            let row = `
                                <tr>
                                    <td>${test.profile_name}</td>
                                    <td>${test.sub_profile_name}</td>
                                    <td>${test.test_name}</td>
                                    <td class="price">${test.price}</td>
                                </tr>
                                <input type="hidden" name="test_ids[]" value="${test.id}">
                            `;
                            $('#test_table_body').append(row);
                            total += parseFloat(test.price);
                        });

                        $('#total_price').text(total.toFixed(2));
                        $('#price').value(total.toFixed(2));
                        calculateTotals();
                    }
                },
                error: function () {
                    alert('Failed to fetch test details.');
                }
            });
        } else {
            $('#total_price').text('0');
            $('#price').value('0');
            $('#total_discount').text('0');
            $('#final_amount').text('0');
        }
    });

    function updateTotalPrice() 
    {
        let total = 0;
        $('#test_table_body .price').each(function () {
            total += parseFloat($(this).text());
        });
        $('#total_price').text(total.toFixed(2));
    }


    $(document).ready(function () {

        updateTotalPrice();

        const packageType = $('#package_type').val();
        if (packageType === 'paid') {
            $('#discounted_type').prop('disabled', false);
            $('#discounted_price').prop('disabled', false);
        } else {
            $('#discounted_type').prop('disabled', true);
            $('#discounted_price').prop('disabled', true);
        }
        calculateTotals();
    });

    $(document).ready(function() 
    {
        $('#organization_type').select2();

        const selectedProfileId = $('#profile').val();
        const selectedTestIds = @json($package->tests->pluck('id'));

        if (selectedProfileId) {
            $.ajax({
                type: "POST",
                url: '{{ route("tests.profiles") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'profile_id': selectedProfileId,
                },
                dataType: 'JSON',
                success: function(response) {
                    $('#test_list').empty().append('<option value="">Select Test</option>');

                    if (response.success == 1 && response.data.length > 0) {
                        $.each(response.data, function(index, test) {
                            const selected = selectedTestIds.includes(test.id) ? 'selected' : '';
                            $('#test_list').append(`<option value="${test.id}" ${selected}>${test.test_name}</option>`);
                        });
                    }
                },
                error: function() {
                    alert('Failed to fetch tests.');
                }
            });
        }
    });

</script>
@endsection