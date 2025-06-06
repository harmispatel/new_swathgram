@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section profile mt-3">
    <div class="container">
        <div class="profile-form">
            <form action="{{ route('test.profile.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if(isset($editProfile))
                    <input type="hidden" name="edit_id" value="{{ encrypt($editProfile->id) }}">
                @endif

                <div class="row mt-4">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Test Department <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <select name="department_name" class="form-control {{ $errors->has('department_name') ? 'is-invalid' : '' }}">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department_name', $editProfile->department_id ?? '') == $department->id ? 'selected' : '' }}>
                                            {{ $department->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Test Profile Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="name"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    value="{{ old('name', $editProfile->name ?? '') }}"
                                    placeholder="Enter Test Profile Name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Interpretation <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="interpretation_flag" value="1"
                                        {{ old('interpretation_flag', $editProfile->interpretation_flag ?? 1) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="interpretation_flag" value="0"
                                        {{ old('interpretation_flag', $editProfile->interpretation_flag ?? 1) == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label">No</label>
                                </div>
                                @error('interpretation_flag')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Interpretation <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                               <textarea name="interpretation"
                                    id="editor"
                                    class="form-control {{ $errors->has('interpretation') ? 'is-invalid' : '' }}"
                                    placeholder="Enter Interpretation">{{ old('interpretation', $editProfile->interpretation ?? '') }}</textarea>

                              
                                @error('interpretation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="department-btn mb-4 mt-4">
                    <button type="submit" class="btn btn-success">
                        {{ isset($editProfile) ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>


        <div class="row">
            <table id="profile_table" class="table table-striped pt-2">
                <thead>
                    <tr>
                        <th>Profile name</th>
                        <th>Department</th>
                        <th>View Test</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profiles as $profile)
                        <tr>
                            <td>{{ $profile->name }}</td>
                            <td>{{ $profile->department->department_name }}</td>
                            <td>
                                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#modal-{{ $profile->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>

                            @if ($profile->department->is_active == 2)
                                <td><span class="pending-rejected ps-1">Not Active</span></td>
                            @else
                                <td><span class="pending-approved ps-1">Active</span></td>
                            @endif

                            <td>
                                <a href="{{ route('test.profile', ['edit_id' => encrypt($profile->id)]) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a onclick="deleteProfile('{{ encrypt($profile->id) }}')" class="ps-2">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="modal-{{ $profile->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $profile->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel-{{ $profile->id }}">Tests in {{ $profile->department->department_name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if($profile->tests->count())
                                            <ul>
                                                @foreach($profile->tests as $test)
                                                    <li>{{ $test->test_name }} (Code: {{ $test->test_code }})</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>No tests available in this profile.</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>

        </div>
    </div>
</section>

@endsection

@section('custom-js')
<script>
    $(document).ready(function() {
        $('#profile_table').DataTable({
            "ordering": false,
            "searching": true,
            "paging": true,
            "info": true,
        });
    });


    function deleteProfile(profileId)
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
                    url: '{{ route("test.profile.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': profileId,
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

<script>
    // Text Editor
    CKEDITOR.ClassicEditor.create(document.getElementById("editor"),
    {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', '|',
                'undo', 'redo',
                '-',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                'alignment', '|',
                'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                'sourceEditing'
            ],
            shouldNotGroupWhenFull: true
        },
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: true
            }
        },
        'height':500,
        fontSize: {
            options: [ 10, 12, 14, 'default', 18, 20, 22 ],
            supportAllValues: true
        },
        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }
            ]
        },
        htmlEmbed: {
            showPreviews: true
        },
        link: {
            decorators: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: {
                        download: 'file'
                    }
                }
            }
        },
        mention: {
            feeds: [
                {
                    marker: '@',
                    feed: [
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                        '@sugar', '@sweet', '@topping', '@wafer'
                    ],
                    minimumCharacters: 1
                }
            ]
        },
        removePlugins: [
            'CKBox',
            'CKFinder',
            'EasyImage',
            'RealTimeCollaborativeComments',
            'RealTimeCollaborativeTrackChanges',
            'RealTimeCollaborativeRevisionHistory',
            'PresenceList',
            'Comments',
            'TrackChanges',
            'TrackChangesData',
            'RevisionHistory',
            'Pagination',
            'WProofreader',
            'MathType'
        ]
    }).then( editor => {
        window.interpretationEditor = editor;
    }).catch(error => {
        console.error('CKEditor failed to initialize:', error);
    });
</script>


@endsection