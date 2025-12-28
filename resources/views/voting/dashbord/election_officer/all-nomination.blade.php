@extends('voting.dashbord.layouts.app')
@section('content')
    <main class="content">
        <div class="container-fluid py-4">
            <!-- KPI Row (voter-centric) -->
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-xl-9">
                    <div class="card card-hover shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h4>Nominations</h4>
                                </div>
                            </div>
                            @foreach ($nominations as $key => $nomination)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <b>{{ $key + 1 }}. Nomination - {{ $nomination->id }}</b>
                                            <button id="nomination-request" data-id={{ $nomination->id }}
                                                class="btn btn-primary">Nomination Request</button>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>


    <!-- Nomination Requests Modal -->
    <div class="modal fade" id="nominationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nomination Requests</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div id="nominationModalBody"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" id="approveSelected">
                        Approve Selected
                    </button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('click', '#nomination-request', function() {
            let nominationId = $(this).data('id');

            $.ajax({
                type: "GET",
                url: "{{ route('nomination.request.get', ['id' => '__ID__']) }}"
                    .replace('__ID__', nominationId),

                success: function(response) {

                    let data = response.nominationRequests;
                    let grouped = {};
                    let html = '';

                    // Group by position
                    data.forEach(item => {
                        if (!grouped[item.position]) {
                            grouped[item.position] = [];
                        }
                        grouped[item.position].push(item);
                    });

                    // Build HTML
                    for (const position in grouped) {
                        html += `
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary">${position}</h6>
                        <ul class="list-group">
                `;

                        grouped[position].forEach(item => {
                            html += `
                        <li class="list-group-item d-flex align-items-center">
                            <input
                                class="form-check-input me-3 nomination-user-checkbox"
                                type="checkbox"
                                value="${item.id}"
                                data-position="${position}"
                                id="user_${item.id}"
                                data-nomination-id="${nominationId}"
                            >
                            <label class="form-check-label" for="user_${item.id}">
                                ${item.user.first_name} ${item.user.last_name}
                            </label>
                        </li>
                    `;
                        });

                        html += `
                        </ul>
                    </div>
                `;
                    }

                    $('#nominationModalBody').html(html);
                    $('#nominationModal').modal('show');
                }
            });
        });

        //Aprrove selected users
        $('#approveSelected').on('click', function() {

            let selectedUsers = [];

            $('.nomination-user-checkbox:checked').each(function() {
                selectedUsers.push({
                    user_id: $(this).val(),
                    position: $(this).data('position'),
                    nominationId: $(this).data('nomination-id')
                });
            });

            if (selectedUsers.length === 0) {
                notyf.error('Please select at least one user to approve.');
                return;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('nomination.request.change.status') }}",
                data: {
                    selectedUsers: selectedUsers
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function(response) {
                    notyf.success(response.message);
                    $('#nominationModal').modal('hide');
                }
            });
        });
    </script>
@endsection
