@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section patients mt-3">
    <div class="container">
        <form id="sort_blogs" action="{{ route('revenue') }}" method="GET">
            <div class="row mb-5">
                <div class="col-md-3 mt-5">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Organization</label>
                        </div>
                        <div class="col-md-8">
                            <select id="organization_type" class="form-select" name="organization_type" onchange="this.form.submit()">
                                <option value="">Select Org</option>
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ request('organization_type') == $organization->id ? 'selected' : '' }}>
                                        {{ $organization->organization_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

               {{-- Test --}}
                <div class="col-md-3 mt-5">
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

                {{-- Date & Time Range --}}
                <div class="col-md-3 mt-5">
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <label class="form-label">From</label>
                        </div>
                        <div class="col-md-5 pe-0">
                            <input type="datetime-local" name="start_datetime" id="start_datetime" class="form-control"
                                value="{{ request('start_datetime') }}" onchange="this.form.submit()">
                        </div>
                        <div class="col-md-5 ps-0">
                            <input type="datetime-local" name="end_datetime" id="end_datetime" class="form-control"
                                value="{{ request('end_datetime') }}" onchange="this.form.submit()">
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mt-5">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" id="clear-btn" class="btn btn-success">Clear</button>
                             
                            <input type="hidden" name="file_type" id="file_type" value="">
                            <button type="button" class="btn btn-success ms-3" id="ajax-export-btn" onclick="exportExcel()">
                                Export to Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <table id="lt_patient_table" class="table table-striped pt-2 mt-3">
                <thead>
                    <tr>
                        <th>Organization</th>
                        <th>No. Of Test</th>
                        <th>No. Of QC</th>
                        <th>Amount</th>
                        <th>Our Revenue</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupedReports as $group)
                        <tr>
                            <td>{{ $group['organization']->organization_name ?? '-' }}</td>
                            <td>{{ $group['test_count'] }}</td>
                            <td></td>
                            <td>$ {{ number_format($group['test_value'], 2) }}</td>
                            <td>$ {{ number_format($group['our_revenue'], 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($group['date'])->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background-color: #ADADAD;">
                    <tr>
                        <th colspan="4" class="text-end" style="color: white;">Total Revenue:</th>
                        <th style="color: black;">$ {{ number_format($totalOurRevenue, 2) }}</th>
                        <th></th>
                    </tr>
                </tfoot>
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
        window.location.href = "{{ route('revenue') }}";
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


<script>
    function exportExcel() {
        document.getElementById('file_type').value = 'excel';
        document.getElementById('sort_blogs').submit();
    }
</script>

@endsection 