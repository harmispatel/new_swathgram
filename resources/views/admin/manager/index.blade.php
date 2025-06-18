@extends('admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section manager mt-3">
    <div class="addbutton">
        <a href="{{ route('admin.manager.create') }}" class="btn btn-primary">Add Manager</a>
    </div>  
    <div class="row">
        <table id="manager_table" class="table table-striped pt-2">
            <thead>
                <tr>
                    <th>Manager Name</th>
                    <th>User name</th>
                    <th>Contact No</th>
                    <th>Organization Name</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($managers as $manager)
                    <tr>
                        <td>{{ $manager->name }}</td>
                        <td>{{ $manager->username }}</td>
                        <td>{{ $manager->contact }}</td>
                        <td>{{ isset($manager->organization) ? $manager->organization->organization_name : '' }}</td>
                        <td>{{ $manager->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.manager.edit', encrypt($manager->id)) }}"><i class="bi bi-pencil-square"></i></a>
                            
                            <a onclick="deleteManager('{{ encrypt($manager->id) }}')" class="ps-2">
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
        $('#manager_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });


    function deleteManager(ManagerId)
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
                    url: '{{ route("manager.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': ManagerId,
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