@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section patients mt-3">
    <div class="container">
        <form id="sort_blogs" action="{{ route('patient.report') }}" method="GET">
            <div class="row">
                {{-- Organization --}}
                <div class="col-md-4 mt-5">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Organization</label>
                        </div>
                        <div class="col-md-9">
                            <select id="organization_type" class="form-select" name="organization_type" onchange="this.form.submit()">
                                <option value="">Select Org. Name</option>
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ request('organization_type') == $organization->id ? 'selected' : '' }}>
                                        {{ $organization->organization_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Camp --}}
                <div class="col-md-4 mt-5">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-label">Camp</label>
                        </div>
                        <div class="col-md-10">
                            <select id="camp_id" class="form-select" name="camp_id" onchange="this.form.submit()">
                                <option value="">Select Camp</option>
                                @foreach ($camps as $camp)
                                    <option value="{{ $camp->id }}" {{ request('camp_id') == $camp->id ? 'selected' : '' }}>
                                        {{ $camp->camp_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Gender --}}
                <div class="col-md-4 mt-5">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-label">Gender</label>
                        </div>
                        <div class="col-md-5">
                            <select id="gender" class="form-select" name="gender" onchange="this.form.submit()">
                                <option value="">Select Gender</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <button type="button" id="clear-btn" class="btn btn-success">Clear</button>
                            <button type="button" id="send-btn" class="btn btn-success ms-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Send">
                                <i class="bi bi-send text-white"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row 2 --}}
            <div class="row mb-2">
                {{-- Device --}}
                <div class="col-md-4 mt-2">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Device</label>
                        </div>
                        <div class="col-md-9">
                            <select id="device_id" class="form-select" name="device_id" onchange="this.form.submit()">
                                <option value="">Select Lab / Device</option>
                                @foreach ($devices as $device)
                                    <option value="{{ $device->id }}" {{ request('device_id') == $device->id ? 'selected' : '' }}>
                                        {{ $device->device_code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Test --}}
                <div class="col-md-4 mt-2">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-label">Test</label>
                        </div>
                        <div class="col-md-10">
                            <select id="test_id" class="form-select" name="test_id" onchange="this.form.submit()">
                                <option value="">Select Test</option>
                                @foreach ($tests as $test)
                                    <option value="{{ $test->id }}" {{ request('test_id') == $test->id ? 'selected' : '' }}>
                                        {{ $test->test_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Date Range --}}
                <div class="col-md-4 mt-2">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-label">Date</label>
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}" onchange="this.form.submit()">
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}" onchange="this.form.submit()">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Final Row --}}
            <div class="row mb-5">
                <div class="col-md-4 mt-2"></div>
                <div class="col-md-4 mt-2"></div>

                <div class="col-md-4 mt-2">
                    <div class="row">
                         <div class="col-md-2">
                        </div>
                        <div class="col-md-6">
                            <select name="file_type" class="form-control">
                                <option value="">Select Type</option>
                                <option value="excel">Select Excel</option>
                                <option value="zip">Select Zip</option>
                            </select>
                        </div>
                        <div class="col-md-4 ps-0">
                            <button onclick="this.form.submit()" class="btn btn-success">Download</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <div class="row">
            <table id="lt_patient_table" class="table table-striped pt-2">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Contact</th>
                        <th>Age</th>
                        <th>Test</th>
                        <th>Camp name</th>
                        <th>Amount</th>
                        <th>Created On</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr>
                            <td>{{ $patient->username }}</td>
                            <td>{{ $patient->mobile_number }}</td>
                            <td>{{ $patient->age }}</td>
                            <td>
                                @php
                                    $testNames = [];
                                    foreach ($patient->reports as $report) {
                                        foreach ($report->testResults as $testResult) {
                                            if ($testResult->test) {
                                                $testNames[] = $testResult->test->test_name;
                                            }
                                        }
                                    }
                                    echo implode(', ', array_unique($testNames));
                                @endphp
                            </td>
                            <td>{{ $patient->camp->camp_name }}</td>
                            <td>
                                @php
                                    $totalAmount = 0;
                                    foreach ($patient->reports as $report) {
                                        foreach ($report->testResults as $testResult) {
                                            $totalAmount += $testResult->value ?? 0;
                                        }
                                    }
                                @endphp
                                {{ number_format($totalAmount, 2) }}
                            </td>
                            <td>{{ $patient->created_at->format('d-m-Y H:i') }}</td>
                            @if ($patient->reports->last()->status == "draft")
                                <td><span class="pending-report">Pending</span></td>
                            @elseif ($patient->reports->last()->status == "approved")
                                 <td><span class="pending-approved">Approved</span></td>
                            @else
                                <td><span class="pending-rejected">Rejected</span></td>
                            @endif
                            
                            <td>
                                <a onclick="deletePatient('{{ encrypt($patient->id) }}')" class="ps-2">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection

@section('custom-js')
<script>
    $(document).ready(function() {
        $('#lt_patient_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });

    document.getElementById('clear-btn').addEventListener('click', function () {
        document.getElementById('sort_blogs').reset();
        window.location.href = "{{ route('patient.report') }}";
    });


    function deletePatient(patientId)
    {
        swal({
            title: "Are you sure You want to Delete It ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelClient) =>
        {
            if (willDelClient)
            {
                $.ajax({
                    type: "POST",
                    url: '{{ route("patient.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': patientId,
                    },
                    dataType: 'JSON',
                    success: function(response)
                    {
                        if (response.success == 1){
                            swal(response.message, {
                                icon: "success",
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1200);
                        }else{
                            swal(response.message, {
                                icon: "error",
                            });
                        }
                    }
                });
            }
            else
            {
                swal("Cancelled", "", "error");
            }
        });
    }
</script>
@endsection