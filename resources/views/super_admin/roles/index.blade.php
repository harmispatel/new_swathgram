@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

    {{-- Page Title --}}

    <div class="pagetitle">

        <h1>Roles</h1>

        <div class="row">

            <div class="col-md-8">

                <nav>

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>

                        <li class="breadcrumb-item active">Roles</li>

                    </ol>

                </nav>

            </div>

            {{-- @can('roles.create') --}}

                <div class="col-md-4" style="text-align: right;">

                    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm new-category custom-btn">

                        <i class="bi bi-plus-lg"></i>

                    </a>

                </div>

            {{-- @endcan --}}

        </div>

    </div>



    {{-- Roles Section --}}

    <section class="section dashboard">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive mt-3 custom_dt_table">

                            <table class="table w-100 mt-5" id="rolesTable">

                                <thead>

                                    <tr>

                                        <th>Id</th>

                                        <th>Name</th>

                                        <th>Permissions</th>

                                        <th style="width: 12%;">Actions</th>

                                    </tr>

                                </thead>

                                <tbody></tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection



{{-- Custom Script --}}

@section('custom-js')

<script type="text/javascript">
    $(function() {
        var table = $('#rolesTable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            ajax: "{{ route('roles.load') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'permissions',
                    name: 'permissions'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });

    function deleteRole(id) {
        swal({
            title: "Are you sure You want to Delete It ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDeleteRole) => {
            if (willDeleteRole) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('roles.destroy') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': id,
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        console.log(response);
                        
                        if (response.success == 1) {
                            swal(response.message, "", "success");
                            $('#rolesTable').DataTable().ajax.reload();
                        } else {
                            swal(response.message, "", "error");
                        }
                    }
                });
            } else {
                swal("Cancelled", "", "error");
            }
        });
    }
</script>

@endsection

