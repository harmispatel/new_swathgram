@extends('pathologist.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section satellite_data mt-3">
    <div class="container">
        <div class="row">
            <table id="satellite_data_table" class="table table-striped pt-2">
                <thead>
                    <tr>
                        <th>Organization</th>
                        <th>Mobile</th>
                        <th>Total Tests</th>
                        <th>Total QC</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($organizations as $organization)
                        <tr>
                            <td>{{ $organization->organization_name }}</td>
                            <td>{{ $organization->contact }}</td>
                            <td>0</td> {{-- this pending this data display in third party api --}}
                            <td>0</td> {{-- this pending this data display in third party api --}}
                            <td>
                                <a href="{{ route('pathologist.satellite_data.show', encrypt($organization->id)) }}" class="ps-2">
                                   <i class="bi bi-eye"></i>
                                </a>
                                {{-- <a onclick="deleteLabTechnician('{{ encrypt($organization->id) }}')" class="ps-2">
                                    <i class="bi bi-trash3"></i>
                                </a> --}}
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
                    url: '{{ route("pathologist.satellite_data.delete") }}',
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