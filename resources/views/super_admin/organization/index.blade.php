@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section organization mt-3">
    <div class="container">
        <div class="addbutton">
            <a href="{{ route('organization.create') }}" class="btn btn-primary">Add Organization</a>
        </div>  
        <div class="row">
            <table id="organization_table" class="table table-striped pt-2">
                <thead>
                    <tr>
                        <th>Organization Name</th>
                        <th>Owner Name</th>
                        <th>User name</th>
                        <th>Contact No</th>
                        <th>Created On</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($organizations as $organization)
                        <tr>
                            <td>{{ $organization->organization_name }}</td>
                            <td>{{ $organization->owner_name }}</td>
                            <td>{{ $organization->username }}</td>
                            <td>{{ $organization->contact }}</td>
                            <td>{{ $organization->created_at->format('d M Y') }}</td>
                            <td>
                            @can('organization')
                                <a href="{{ route('organization.edit', encrypt($organization->id)) }}"><i class="bi bi-pencil-square"></i></a>
                             @endcan   
                                <a onclick="deleteOrganization('{{ encrypt($organization->id) }}')" class="ps-2">
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
        $('#organization_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });


    function deleteOrganization(OrganizationId)
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
                    url: '{{ route("organization.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': OrganizationId,
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