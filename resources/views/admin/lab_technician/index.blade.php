@extends('admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section lab_technician mt-3">
    <div class="addbutton">
        <a href="{{ route('admin.lab_technician.create') }}" class="btn btn-primary">Add Lab Technician</a>
    </div>  
    <div class="row">
        <table id="lab_technician_table" class="table table-striped pt-2">
            <thead>
                <tr>
                    <th>Lab Technician Name</th>
                    <th>User name</th>
                    <th>Contact No</th>
                    <th>Camp Name</th>
                    <th>Organization Name</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($lab_technicians as $lab_technician)
                    <tr>
                        <td>{{ $lab_technician->name }}</td>
                        <td>{{ $lab_technician->username }}</td>
                        <td>{{ $lab_technician->contact }}</td>
                        <td>
                            @php
                                $campNames = $lab_technician->organizations && $lab_technician->organizations->camps
                                    ? $lab_technician->organizations->camps->pluck('camp_name')->toArray()
                                    : [];
                            @endphp

                            {{ count($campNames) ? implode(', ', $campNames) : '  -  ' }}
                        </td>
                        <td>{{ isset($lab_technician->organizations) ? $lab_technician->organizations->organization_name : '' }}</td>
                        <td>{{ $lab_technician->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.lab_technician.edit', encrypt($lab_technician->id)) }}"><i class="bi bi-pencil-square"></i></a>
                            
                            <a onclick="deleteLabTechnician('{{ encrypt($lab_technician->id) }}')" class="ps-2">
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
        $('#lab_technician_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });


    function deleteLabTechnician(lab_technicianId)
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
                    url: '{{ route("admin.lab_technician.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': lab_technicianId,
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