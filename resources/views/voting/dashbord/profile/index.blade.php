@extends('voting.dashbord.layouts.app')
@section('content')
    <main class="content">
        <div class="container-fluid py-4">


            <!-- Profile Management -->
            <div class="row g-3 mt-1" id="profile">
                <div class="col-12 col-xl-12">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white d-flex align-items-center justify-content-between">
                            <span class="fw-semibold"><i class="bi bi-person-circle me-2"></i> Profile</span>
                        </div>
                        <div class="card-body">

                            <div class="col-auto text-center">
                                <img id="profilePreview" src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile"
                                    class="rounded-circle border border-2 shadow-sm" width="112" height="112"
                                    style="object-fit:cover;" />
                            </div>
                            <div class="col">
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">First Name</label>
                                        <input readonly value="{{ $user->first_name }}" id="profileName"
                                            class="form-control" placeholder="Your name" />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Last Name</label>
                                        <input readonly value="{{ $user->last_name }}" id="profileName" class="form-control"
                                            placeholder="Your name" />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Email</label>
                                        <input readonly value="{{ $user->email }}" id="profileEmail"
                                            class="form-control" />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Student Id</label>
                                        <input readonly value="{{ $user->student_id }}" id="profileEmail"
                                            class="form-control" />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Department</label>
                                        <select name="department" id="" class="form-select">

                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ $user->department == $department->id ? 'selected' : '' }}>
                                                    {{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-1" id="danger">
                <div class="col-12">
                    <div class="card shadow-sm danger-zone">
                        <div class="card-header bg-white">
                            <span class="fw-semibold ">
                                Change Student Department and Profile Image</span>
                        </div>
                        <div class="card-body">
                            <div class="col-12 d-flex gap-2">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#twoFieldModal"
                                    type="button"><i class="bi bi-save me-1"></i>
                                    Change Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="row g-3 mt-1" id="danger">
                <div class="col-12">
                    <div class="card shadow-sm danger-zone">
                        <div class="card-header bg-white">
                            <span class="fw-semibold text-danger"><i class="bi bi-exclamation-triangle me-2"></i>
                                Account Deletion</span>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Deleting your account removes your login and profile. <strong>Historical
                                    election data and anonymized vote records remain intact</strong> to protect election
                                integrity.</p>
                            <button class="btn btn-outline-danger delete-account" data-bs-toggle="modal"><i
                                    class="bi bi-trash me-1"></i> Delete My
                                Account</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile data change Modal -->
            <div class="modal fade" id="twoFieldModal" tabindex="-1" aria-labelledby="twoFieldLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form class="modal-content needs-validation profile-update" id="twoFieldForm" method="POST"
                        action="{{ route('user.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="twoFieldLabel">Update details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="mb-3">
                                <label for="fieldDept" class="form-label">Department</label>
                                <select name="department" id="" class="form-select">

                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $user->department == $department->id ? 'selected' : '' }}>
                                            {{ $department->department_name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="mb-3">
                                <label for="fieldName" class="form-label">Profile Image</label>

                                <input type="file" class="form-control mb-3" id="profile-image" name="profile_image">
                                <img id="profile-image-preview" src="{{ asset('storage/' . $user->profile_image) }}"
                                    alt="Profile" class="rounded-circle border border-2 shadow-sm" width="112"
                                    height="112" style="object-fit:cover;" />
                            </div>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#profile-image').on('change', function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#profile-image-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);

            });



            $('.profile-update').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#twoFieldModal').modal('hide');
                        notyf.success(response.message);
                        setTimeout(() => window.location.reload(), 450);
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(index, value) {
                            notyf.error(value[0]);
                        });
                    }
                });

            });

            $('.delete-account').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('user.delete') }}",
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                notyf.success(response.message);
                                setTimeout(() => window.location.href =
                                    "{{ route('login') }}", 450);
                            },
                            error: function(xhr) {
                                notyf.error(xhr.responseJSON.message ||
                                    'An error occurred.');
                            }
                        });
                    }
                });
            });


        });
    </script>
@endsection
