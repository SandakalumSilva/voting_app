@extends('voting.dashbord.layouts.app')
@section('content')
    <main class="content">
        <div class="container-fluid py-4">
            <!-- Filters Row -->
            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                <h1 class="h4 mb-0">All Enrollments</h1>

            </div>

            <div class="row g-3">
                <table class="table table-striped table-bordered table-hover align-middle all-enrollment">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Current Position</th>
                            <th scope="col">Request Position</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('.all-enrollment').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.all.enrollment') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'current_position',
                        name: 'current_position'
                    },
                    {
                        data: 'position',
                        name: 'position'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).on('click', '.approve-enrollment,.reject-enrollment', function() {
                var id = $(this).data('id');
                var status = $(this).data('status');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Click it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/voter-status/" + id + "/" + status,
                            type: 'GET',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                notyf.success(response.message);
                                setTimeout(() => window.location.reload(), 450);
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
