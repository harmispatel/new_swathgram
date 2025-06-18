@extends('admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section package mt-3">
    <div class="addbutton">
        <a href="{{ route('admin.package.create') }}" class="btn btn-primary">Add Package</a>
    </div>  
    <div class="row">
        <table id="package_table" class="table table-striped pt-2">
            <thead>
                <tr>
                    <th>Package name</th>
                    <th>Package Type</th>
                    <th>Package Price</th>
                    <th>Organization Name</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($packages as $package)
                    <tr>
                        <td>{{ $package->package_name }}</td>
                        <td>{{ $package->package_type }}</td>
                        <td>{{ $package->price }}</td>
                        <td>{{ $package->organizations->pluck('organization_name')->join(', ') }}</td>
                        <td>{{ $package->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.package.edit', encrypt($package->id)) }}"><i class="bi bi-pencil-square"></i></a>
                            
                            <a onclick="deletePackage('{{ encrypt($package->id) }}')" class="ps-2">
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
        $('#package_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });


    function deletePackage(packageId)
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
                    url: '{{ route("admin.package.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': packageId,
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