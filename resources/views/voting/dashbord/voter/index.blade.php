@extends('voting.dashbord.layouts.app')
@section('content')
    <main class="content">
        <div class="container-fluid py-4">


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
                {{-- <div class=" col-12 col-sm-6 col-xl-4">

                </div> --}}
                {{-- <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card card-hover shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-muted small">Eligible Elections</div>
                                    <div class="h3 mb-0" id="kpiEligible">—</div>
                                </div>
                                <span class="text-primary fs-3"><i class="bi bi-clipboard2-check"></i></span>
                            </div>
                            <div class="text-muted small mt-2">Based on your department</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card card-hover shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-muted small">Active Ballots</div>
                                    <div class="h3 mb-0" id="kpiActiveBallots">—</div>
                                </div>
                                <span class="text-primary fs-3"><i class="bi bi-envelope-open"></i></span>
                            </div>
                            <div class="text-muted small mt-2">Open now</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card card-hover shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-muted small">Completed Votes</div>
                                    <div class="h3 mb-0" id="kpiCompleted">—</div>
                                </div>
                                <span class="text-primary fs-3"><i class="bi bi-check2-circle"></i></span>
                            </div>
                            <div class="text-muted small mt-2">Your past ballots</div>
                        </div>
                    </div>
                </div> --}}

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
@endsection
