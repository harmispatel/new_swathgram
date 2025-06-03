@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section department mt-3">
    <div class="container">
        <div class="department-form">
          <form action="{{ route('department.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if(isset($editDepartment))
                    <input type="hidden" name="edit_id" value="{{ encrypt($editDepartment->id) }}">
                @endif

                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Department Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="department_name"
                                    class="form-control {{ $errors->has('department_name') ? 'is-invalid' : '' }}"
                                    placeholder="Enter Department"
                                    value="{{ old('department_name', $editDepartment->department_name ?? '') }}">
                                @if($errors->has('department_name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('department_name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="department-btn mb-4 mt-4">
                    <button type="submit" class="btn btn-success">
                        {{ isset($editDepartment) ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>

        </div>

        <div class="row">
            <table id="department_table" class="table table-striped pt-2">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>View Test</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <td>{{ $department->department_name }}</td>
                            <td><i class="bi bi-eye"></i></td>
                            @if ($department->is_active == 2)
                                <td><span class="pending-rejected ps-1">Not Active</span></td>
                            @else
                                <td><span class="pending-approved ps-1">Active</span></td>
                            @endif
                            <td>
                                <a href="{{ route('department', ['edit_id' => encrypt($department->id)]) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                
                                <a onclick="deleteLabTechnician('{{ encrypt($department->id) }}')" class="ps-2">
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
        $('#department_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });
    
    function deleteLabTechnician(departmentId)
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
                    url: '{{ route("department.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': departmentId,
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