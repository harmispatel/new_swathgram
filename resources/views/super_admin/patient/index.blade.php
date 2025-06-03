@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section patients mt-3">
    <div class="container">
        <form id="sort_blogs" action="{{ route('patient') }}" method="GET">
            <div class="row mb-5">
                <div class="col-md-4 mt-5">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Organization</label>
                        </div>
                        <div class="col-md-9">
                            <select id="organization_type" class="form-select" name="organization_type" onchange="this.form.submit()">
                                <option value="">Select Org. Name</option>
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ request('organization_type') == $organization->id ? 'selected' : '' }}>
                                        {{ $organization->organization_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-5">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-label">Camp</label>
                        </div>
                        <div class="col-md-10">
                            <select id="camp_id" class="form-select" name="camp_id" onchange="this.form.submit()">
                                <option value="">Select Camp</option>
                                @foreach ($camps as $camp)
                                    <option value="{{ $camp->id }}" {{ request('camp_id') == $camp->id ? 'selected' : '' }}>
                                        {{ $camp->camp_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-5">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-label">Gender</label>
                        </div>
                        <div class="col-md-10">
                            <select id="gender" class="form-select" name="gender" onchange="this.form.submit()">
                                <option value="">Select Gender</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <table id="lt_patient_table" class="table table-striped pt-2">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Patient ID</th>
                        <th>Contact</th>
                        <th>Age</th>
                        <th>Camp name</th>
                        <th>Created On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr>
                            <td>{{ $patient->username }}</td>
                            <td>{{ $patient->id }}</td>
                            <td>{{ $patient->mobile_number }}</td>
                            <td>{{ $patient->age }}</td>
                            <td>{{ $patient->camp->camp_name }}</td>
                            <td>{{ $patient->created_at }}</td>
                            <td>
                                <a onclick="deletePatient('{{ encrypt($patient->id) }}')" class="ps-2">
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
        $('#lt_patient_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });


    function deletePatient(patientId)
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
                    url: '{{ route("patient.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': patientId,
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