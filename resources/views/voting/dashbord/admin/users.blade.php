@extends('voting.dashbord.layouts.app')

@section('content')
    <main class="content">
        <div class="container-fluid py-4">
            <!-- Filters Row -->
            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                <h1 class="h4 mb-0">All Voters</h1>

            </div>

            <div class="row g-3">
                <table class="table table-striped table-bordered table-hover align-middle all-users">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
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

            $('.all-users').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.all.voters') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'last_name',
                        name: 'last_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).on('click', '.voter-delete', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
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
                            url: "/admin/voter-delete/" + id,
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
        })
    </script>
@endsection
