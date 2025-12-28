@extends('voting.dashbord.layouts.app')
@section('content')
    <main class="content">
        <div class="container-fluid py-4">

            <div class="row g-3 mt-1" id="profile">
                <div class="col-12 col-xl-12">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white">
                            <span class="fw-semibold"><i class="bi bi-clock-history me-2"></i> Ongoing Nomination</span>
                        </div>
                        @foreach ($nominations as $key => $election)
                            <span class="fw-semibold mx-3">{{ $key + 1 . ' .' }}
                                <button id="nomination-id" data-date={{ $election->end_date }} data-id={{ $election->id }}
                                    class="btn btn-primary w-30 mt-3 mb-1">Nomination No. {{ $election->id }}</button>
                                <button data-id="{{ $election->id }}" class="btn btn-warning w-30 mt-3 mb-1">
                                    Status:
                                    {{ $election->nominationRequests->first()->status ?? 'Not Applied' }}
                                </button>
                                <button data-date={{ $election->end_date }} id="withdraw-nomination"
                                    data-id={{ $election->nominationRequests->first()->id ?? 0 }}
                                    class="btn btn-danger w-30 mt-3 mb-1">Withdraw Nomination
                                    {{ $election->id }}</button>
                            </span>
                        @endforeach

                    </div>
                </div>

            </div>

            <!-- Profile Management -->
            <div class="row g-3 mt-1" id="profile">
                <div class="col-12 col-xl-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white">
                            <span class="fw-semibold"><i class="bi bi-clock-history me-2"></i> Recent Results</span>
                        </div>
                        @foreach ($results as $key => $election)
                            <span class="fw-semibold mx-3">{{ $key + 1 . ' .' }}
                                <a target="_blank"
                                    href=" {{ route('election.get.election.result', $election->election_id) }} "
                                    class="btn btn-sm btn-primary mb-1 mt-1">{{ $election->election->election_name }}</a>
                            </span>
                        @endforeach

                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white">
                            <span class="fw-semibold"><i class="bi bi-clock-history me-2"></i> Ongoing Voting</span>
                        </div>
                        @foreach ($elections as $key => $election)
                            <span class="fw-semibold mx-3">{{ $key + 1 . ' .' }}
                                <button class="btn btn-sm btn-primary mb-1 mt-1 election-candidtates" data-bs-toggle="modal"
                                    data-bs-target="#electionCandidatesModal" data-election="{{ $election->election_id }}">
                                    {{ $election->election->election_name }}
                                </button>

                            </span>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
        <div class="container-fluid py-4">
            <h3>Ongoing Elections Current Results</h3>
            <!-- KPI Row (voter-centric) -->
            <div class="row g-3 elction-result">


            </div>

        </div>
    </main>


    <div class="modal fade" id="electionCandidatesModal" tabindex="-1" aria-labelledby="createElectionLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="createElectionLabel">Votes Election</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="electionForm" method="POST" action="{{ route('voting.voter.vote') }}">
                        @csrf
                        <input type="hidden" name="election_id" id="election_id">
                        <b>Select the candidates you want to vote for</b>
                        <div class="form-check mb-3" id="election">

                        </div>

                        <div class="modal-footer">
                            <button type="submit" form="electionForm" class="btn btn-primary">Save
                                Election</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="positionsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Select Positions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="positions-form" action="{{ route('nomination.request.create') }}" method="POST">
                        @csrf
                        <div id="positions-container" class="row gy-2">
                            <!-- Checkboxes will be injected here -->
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" form="positions-form" id="request-nomination" class="btn btn-primary">
                        Request Nomination
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
        $(".election-candidtates").on('click', function(e) {
            e.preventDefault();
            const id = $(this).data('election');
            $("#election_id").val(id);
            $.ajax({
                type: "GET",
                url: "{{ route('voting.voter.election', ':id') }}".replace(':id', id),
                success: function(response) {
                    let candidates = response.candidates;
                    let electionDiv = $('#election'); // container div for checkboxes
                    electionDiv.empty(); // clear old checkboxes

                    candidates.forEach(function(candidate) {
                        let checkbox = $(`
                            <div class="form-check">
                                <input class="form-check-input" type="radio" 
                                    id="candidate_${candidate.id}" 
                                    name="candidates" 
                                    value="${candidate.id}">
                                <label class="form-check-label" for="candidate_${candidate.id}">
                                    ${candidate.first_name} ${candidate.last_name}
                                </label>
                            </div>
                        `);
                        electionDiv.append(checkbox);
                    });


                }
            });

        });

        $("#electionForm").on("submit", function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(form[0]);
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    const vote_id = response.vote_id;
                    $('#electionCandidatesModal').modal('hide');
                    notyf.success(response.message);

                    window.location.href = "/voter/otp-verify/" + vote_id;
                },
                error: function(xhr) {

                    notyf.error(xhr.responseJSON.message);

                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ route('election.get.ongoing.election') }}",
                success: function(response) {
                    let electionResult = $('.elction-result');
                    electionResult.empty();

                    $.each(response.electionsName, function(index, election) {
                        let votesHtml = ""; // store candidates markup here

                        $.each(response.elections[election]['candidates'], function(index,
                            candidate) {
                            votesHtml += `
                <div >
                    <div>
                        <div class="text-muted small">${candidate}</div>
                       
                        <div class="progress">
  <div class="progress-bar" role="progressbar" style="width: ${response.elections[election]['votes'][candidate]}%;" aria-valuenow="${response.elections[election]['votes'][candidate]}" aria-valuemin="0" aria-valuemax="100">${response.elections[election]['votes'][candidate]}%</div>
</div>
                    </div>
                    
                </div>
            `;
                        });

                        electionResult.append(`
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card card-hover shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-muted small">${election}</div>
                                <div class="h3 mb-0" id="kpiEligible">—</div>
                            </div>
                            <span class="text-primary fs-3"><i class="bi bi-clipboard2-check"></i></span>
                        </div>
                        ${votesHtml}
                    </div>
                </div>
            </div>
        `);
                    });
                }

            });
        });
    </script>
    <script>
        $('#nomination-id').on('click', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            let url = "{{ route('nomination.get', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                type: "GET",
                url: url,
                success: function(response) {

                    const nomination = response.nominations[0];
                    const positions = JSON.parse(nomination.positions);

                    // Get user's requested position (if exists)
                    let requestedPosition = null;

                    if (nomination.nomination_requests.length > 0) {
                        requestedPosition = nomination.nomination_requests[0].position;
                    }

                    let html = '';

                    positions.forEach((position, index) => {

                        const isChecked = position === requestedPosition ? 'checked' : '';
                        const isDisabled = requestedPosition ? 'disabled' : '';

                        html += `
                <div class="col-12">
                    <div class="form-check">
                        <input hidden name="nomination_id" value="${nomination.id}" />
                        <input name="nomination_end_date" value="${nomination.end_date}" data-date="${nomination.end_date}" hidden />

                        <input
                            class="form-check-input"
                            type="radio"
                            name="positions"
                            value="${position}"
                            id="position_${index}"
                            ${isChecked}
                            
                        >

                        <label class="form-check-label fw-semibold" for="position_${index}">
                            ${position}
                        </label>
                    </div>
                </div>
            `;
                    });

                    $('#positions-container').html(html);

                    // Show modal
                    const modal = new bootstrap.Modal(
                        document.getElementById('positionsModal')
                    );
                    modal.show();
                }
            });
        });
    </script>

    <script>
        $("#positions-form").on("submit", function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            const URL = $(this).attr('action');

            const date = $(this).find('input[name="nomination_end_date"]').data('date');
           
            const nominationDate = new Date(date);
            const now = new Date();
            if (now > nominationDate) {
                Swal.fire('Error!', 'Nomination period has ended. You cannot vote now.', 'error');
                return;
            }
            console.log(formData);
            $.ajax({
                url: URL,
                type: 'POST',
                data: formData,
                success: function(response) {
                    notyf.success(response.message);
                    setTimeout(() => window.location.reload(), 450);
                },
                error: function(xhr) {
                    notyf.error(xhr.responseJSON.message);
                }
            });

        });

        //nomination withdraw
        $('#withdraw-nomination').on('click', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const date = $(this).data('date');

            const nominationDate = new Date(date);
            const now = new Date();
            if (now > nominationDate) {
                Swal.fire('Error!', 'Nomination period has ended. You cannot withdraw now.', 'error');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to withdraw this nomination!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, withdraw it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect or AJAX call to withdraw
                    fetch(`/nomination-requests/withdraw-request/${id}`, {
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire(
                                'Withdrawn!',
                                data.message || 'Your nomination has been withdrawn.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        })
                        .catch(err => {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        });
                }
            });


        });
    </script>
@endsection
