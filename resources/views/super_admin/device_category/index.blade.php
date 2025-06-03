@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section device mt-3">
    <div class="addbutton">
        <a href="{{ route('device.create') }}" class="btn btn-primary">Add Device</a>
        <a href="{{ route('device.category.create') }}" id="category_button_add" class="btn btn-primary">Add Create New Product / Innovation</a>
    </div>  
    <div class="row">
        <table id="device_category_table" class="table table-striped pt-2">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Created On</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($device_categories as $device_categorie)
                    <tr>
                        <td>{{ $device_categorie->device_name }}</td>
                        <td>{{ $device_categorie->created_at->format('d M Y') }}</td>
                        <td>{{ $device_categorie->status }}</td>
                        <td>
                            <a href="{{ route('device.category.edit', encrypt($device_categorie->id)) }}"><i class="bi bi-pencil-square"></i></a>
                            <a onclick="deleteDeviceCategory('{{ encrypt($device_categorie->id) }}')" class="ps-2">
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
        $('#device_category_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });


    function deleteDeviceCategory(deviceId)
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
                    url: '{{ route("device.category.delete") }}',
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