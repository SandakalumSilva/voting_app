@extends('voting.dashbord.layouts.app')
@section('content')
    <main class="content">
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
@endsection

@section('scripts')
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
