@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section camp mt-3">
    <div class="container">
        <form class="" id="sort_blogs" action="" method="GET">
            <div class="row mb-5">
                    <div class="col-md-4 mt-5">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Organization</label>
                            </div>
                            <div class="col-md-9">
                                <select id="organization_type" class="form-select {{ $errors->has('organization_type') ? 'is-invalid' : '' }}" name="organization_type">
                                    <option value="">Select Org. Name</option>
                                    @foreach ($organizations as $organization)
                                        <option value="{{ $organization->id }}">{{ $organization->organization_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mt-5">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Camp</label>
                            </div>
                            <div class="col-md-9">
                                <select id="camp_id" class="form-select {{ $errors->has('camp_id') ? 'is-invalid' : '' }}" name="camp_id">
                                    <option value="">Select Camp</option>
                                    @foreach ($camps as $camp)
                                        <option value="{{ $camp->id }}">{{ $camp->camp_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mt-5">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Gender</label>
                            </div>
                            <div class="col-md-9">
                                <select id="gender" class="form-select" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
        </from>

        <div class="row">
            <table id="patient_table" class="table table-striped pt-2">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Patient ID</th>
                        <th>Contact</th>
                        <th>Age</th>
                        <th>Camp name</th>
                        <th>Organization</th>
                        <th>Created On</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($patients as $patient)
                        <tr>
                            <td></td>
                            <td>td>
                            <td></td>
                            <td>
                            </td>
                            <td>
                                
                            </td>
                            <td></td>
                            <td>
                                <a onclick="deletePatient()" class="ps-2">
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
        $('#patient_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });


    function deletePatient(campId)
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