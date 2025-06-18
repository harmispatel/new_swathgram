@extends('manager.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section pathologist mt-3">
    <div class="addbutton">
        <a href="{{ route('manager.pathologist.create') }}" class="btn btn-primary">Add Pathologist</a>
    </div>  
    <div class="row">
        <table id="pathologist_table" class="table table-striped pt-2">
            <thead>
                <tr>
                    <th>Pathologist Name</th>
                    <th>User name</th>
                    <th>Contact No</th>
                    <th>Camp Name</th>
                    <th>Organization Name</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($pathologists as $pathologist)
                    <tr>
                        <td>{{ $pathologist->name }}</td>
                        <td>{{ $pathologist->username }}</td>
                        <td>{{ $pathologist->contact }}</td>
                        <td>
                            @php
                                $campNames = [];
                                foreach ($pathologist->organizations as $organization) {
                                    foreach ($organization->camps as $camp) {
                                        $campNames[] = $camp->camp_name;
                                    }
                                }
                            @endphp

                            {{ count($campNames) > 0 ? implode(', ', $campNames) : ' - ' }}
                        </td>


                        <td>{{ $pathologist->organizations->pluck('organization_name')->join(', ') }}</td>
                        <td>{{ $pathologist->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('manager.pathologist.edit', encrypt($pathologist->id)) }}"><i class="bi bi-pencil-square"></i></a>
                            
                            <a onclick="deletePathologist('{{ encrypt($pathologist->id) }}')" class="ps-2">
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
        $('#pathologist_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });


    function deletePathologist(PathologistId)
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
                    url: '{{ route("manager.pathologist.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': PathologistId,
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