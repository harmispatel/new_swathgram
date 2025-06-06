@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section patients mt-3">
    <div class="container">
        <form id="sort_blogs" action="{{ route('patient.report') }}" method="GET">
            <div class="row">
                {{-- Organization --}}
                <div class="col-md-4 mt-3">
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

                {{-- Device --}}
                <div class="col-md-4 mt-3">
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
                <div class="col-md-4 mt-3">
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
            </div>
        </form>

        <div class="row mt-5">
            <table id="lt_patient_table" class="table table-striped pt-2">
                <thead>
                    <tr>
                        <th>Test Name</th>
                        <th>Code</th>
                        <th>Device ID</th>
                        <th>L1</th>
                        <th>L2</th>
                        <th>C1</th>
                        <th>C2</th>
                        <th>c3</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($qc_reports as $qc_report)
                        <tr>
                            <td>{{ $qc_report->test->test_name }}</td>
                            <td></td>
                            <td></td>
                            <td>{{ $qc_report->L1 }}</td>
                            <td>{{ $qc_report->L2 }}</td>
                            <td>{{ $qc_report->C1 }}</td>
                            <td>{{ $qc_report->C2 }}</td>
                            <td>{{ $qc_report->C3 }}</td>
                            <td>{{ $qc_report->created_at }}</td>
                            @if ($device->status == 0)
                                <td><span class="pending-report">Pending</span></td>
                            @elseif ($device->status == 1)
                                 <td><span class="pending-approved">Approved</span></td>
                            @else
                                <td><span class="pending-rejected">Rejected</span></td>
                            @endif
                            <td>
                                <a onclick="deletePatient('{{ encrypt($qc_report->id) }}')" class="ps-2">
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