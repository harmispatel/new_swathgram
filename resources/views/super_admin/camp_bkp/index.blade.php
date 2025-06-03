@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section camp mt-3">
    <div class="addbutton">
        <a href="{{ route('camp.create') }}" class="btn btn-primary">Add Camp</a>
    </div>  
    <div class="row">
        <table id="camp_table" class="table table-striped pt-2">
            <thead>
                <tr>
                    <th>Organization</th>
                    <th>Camp Name</th>
                    <th>Start/End Date</th>
                    <th>Lab Technician</th>
                    <th>Pathologist</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($camps as $camp)
                    <tr>
                        <td>{{ $camp->organizations->organization_name }}</td>
                        <td>{{ $camp->camp_name }}</td>
                        <td>{{ $camp->camp_start_date }} / {{ $camp->camp_end_date }}</td>
                        <td>
                           {{ $camp->LabTechnician->username }}
                        </td>
                        <td>
                            {{ $camp->pathologist->username }}
                        </td>
                        <td>{{ $camp->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('camp.edit', encrypt($camp->id)) }}"><i class="bi bi-pencil-square"></i></a>
                            
                            <a onclick="deleteLabTechnician('{{ encrypt($camp->id) }}')" class="ps-2">
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
        $('#camp_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });


    function deleteLabTechnician(campId)
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
                    url: '{{ route("camp.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': campId,
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