@extends('admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section satellite_data mt-3">
    <div class="container">
        <div class="organization-name pt-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Organization Name : </label>
                    </div>
                    <div class="col-md-8">
                        {{ $organization->organization_name }}
                    </div>  
                </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <table id="satellite_data_table" class="table table-striped pt-2">
                <thead>
                    <tr>
                        <th>Lab Id/UID</th>
                        <th>Device Serial No.</th>
                        <th>Total Tests</th>
                        <th>Total QC</th>
                        <th>Details</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $device)
                        <tr>
                            <td>{{ $device->device_code }}</td>
                            <td>{{ $device->device_serial }}</td>
                            <td>0</td> {{--  this pending for display in third party api --}}
                            <td>0</td> {{--  this pending for display in third party api --}}
                            <td>{{ $device->notes ?? '' }}</td>
                            @if ($device->status == "maintenance")
                                <td><span class="pending-report">Maintenance</span></td>
                            @elseif ($device->status == "active")
                                 <td><span class="pending-approved">Active</span></td>
                            @else
                                <td><span class="pending-rejected">Not Active</span></td>
                            @endif
                            <td></td>
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
        $('#satellite_data_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });


    function deleteLabTechnician(satellite_dataId)
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
                    url: '{{ route("admin.satellite_data.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': satellite_dataId,
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