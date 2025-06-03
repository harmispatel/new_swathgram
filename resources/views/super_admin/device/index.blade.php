@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section device mt-3">
    <div class="addbutton">
        <a href="{{ route('device.create') }}" class="btn btn-primary">Add Device</a>
    </div> 
    <div class="row">
        <table id="device_table" class="table table-striped pt-2">
            <thead>
                <tr>
                    <th>Lab Id/UID</th>
                    <th>Device Serial No.</th>
                    <th>Camp</th>
                    <th>Organization Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($devices as $device)
                    <tr>
                        <td>{{ $device->device_code }}</td>
                        <td>{{ $device->device_serial }}</td>
                        <td>
                             @php
                                $campNames = $device->organizations && $device->organizations->camps
                                    ? $device->organizations->camps->pluck('camp_name')->toArray()
                                    : [];
                            @endphp

                            {{ count($campNames) ? implode(', ', $campNames) : '  -  ' }} 
                        </td>
                        <td>{{ isset($device->organizations) ? $device->organizations->organization_name : '' }}</td>
                        <td>{{ $device->status }}</td>
                        <td>
                            <a href="{{ route('device.edit', encrypt($device->id)) }}"><i class="bi bi-pencil-square"></i></a>
                            
                            <a onclick="deleteDevice('{{ encrypt($device->id) }}')" class="ps-2">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection

@section('custom-js')
<script>
    $(document).ready(function() {
        $('#device_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });


    function deleteDevice(deviceId)
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
                    url: '{{ route("device.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': deviceId,
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