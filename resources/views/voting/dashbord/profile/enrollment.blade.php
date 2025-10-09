@extends('voting.dashbord.layouts.app')
@section('content')
    <main class="content">
        <div class="container-fluid py-4">


            <div class="row g-3 mt-1" id="danger">
                <div class="col-12">
                    <div class="card shadow-sm danger-zone">
                        @if ($user->enrollmentRequests->isNotEmpty() && $user->enrollmentRequests[0]->status == 'pending')
                            <div class="card-header bg-white">
                                <span class="fw-semibold text-warning">Your enrollment request is pending.</span>
                            </div>
                        @else
                            <div class="card-header bg-white">
                                <span class="fw-semibold ">
                                    Request to become a @if ($user->role != 'voter')
                                        <span class="text-primary">Voter</span>
                                    @else
                                        <span class="text-primary">Candidate</span>
                                    @endif
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="col-12 d-flex gap-2">
                                    <button class="btn btn-primary enrollemnt" data-user="{{ $user->id }}"
                                        type="button"><i class="bi bi-save me-1"></i>
                                        Request Enrollment</button>
                                    </button>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>



        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.enrollemnt').on('click', function() {
                var userId = $(this).data('user');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to request enrollment!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, request it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('user.enrollment.post') }}",
                            type: 'POST',
                            data: {
                                user_id: userId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Requested!',
                                    response.message,
                                    'success'
                                );
                                window.location.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    xhr.responseJSON.message,
                                    'error'
                                );
                            }
                        });
                    }
                })
            });
        });
    </script>
@endsection
