@extends('pathologist.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section lab_technician mt-3">
    {{-- <div class="addbutton mb-5">
        <a href="{{ route('test.create') }}" class="btn btn-primary">Add Test</a>
        <a href="{{ route('test.profile') }}" class="btn btn-primary">Add Profile</a>
        <a href="{{ route('test.sub-profile') }}" class="btn btn-primary">Add Sub-Profile</a>
        <a href="{{ route('department') }}" class="btn btn-primary">Add Department</a>
        <a href="{{ route('lab_technician.create') }}" class="btn btn-primary">Add Widal Test</a>
    </div> --}}

    <div class="row">
        <table id="test_table" class="table table-striped pt-2">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Profile</th>
                    <th>Department</th>
                    <th>Unit</th>
                    <th>Bio.Ref. (M)</th>
                    <th>Bio.Ref. (F)</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
               
                @foreach ($tests as $test)
                    <tr>
                        <td>{{ $test->test_name }}</td>
                        <td>{{ $test->test_code }}</td>
                        <td>{{ $test->testProfile->name }}</td>
                        <td>{{ $test->department->department_name }}</td>
                        <td>{{ $test->unit }}</td>
                        <td>{{ $test->male_ref_range }}</td>
                        <td>{{ $test->female_ref_range }}</td>
                        @if ($test->is_active == 2)
                            <td><span class="pending-rejected ps-1">Not Active</span></td>
                        @else
                            <td><span class="pending-approved ps-1">Active</span></td>
                        @endif
                        <td>{{ $test->price }}</td>
                        <td>
                            <a href="{{ route('pathologist.test.edit', encrypt($test->id)) }}"><i class="bi bi-pencil-square"></i></a>
                            <a onclick="deleteTest('{{ encrypt($test->id) }}')" class="ps-2">
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
        $('#test_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });


    function deleteTest(TestId)
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
                    url: '{{ route("admin.test.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': TestId,
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