@extends('voting.dashbord.layouts.app')
@section('content')
    <main class="content">
        <div class="container-fluid py-4">



            <!-- Danger Zone -->
            <div class="row g-3 mt-1" id="danger">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <span class="fw-semibold text-primary">
                                <i class="bi bi-ballot me-2"></i> Create Election
                            </span>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                Set up a new election by adding <strong>name, date, positions, voting period, candidates,
                                    and eligible voters</strong>.
                            </p>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#createElectionModal">
                                <i class="bi bi-plus-circle me-1"></i> New Election
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-1" id="danger">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <span class="fw-semibold text-primary">
                                <i class="bi bi-ballot me-2"></i> Ongoing Elections
                            </span>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                Check ongoing elections <strong>results</strong>.
                            </p>
                            <a class="btn btn-outline-primary" href="{{ route('election.ongoing.election') }}">
                                <i class="bi bi-plus-circle me-1"></i> Ongoing Election
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-1" id="danger">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <span class="fw-semibold text-primary">
                                <i class="bi bi-ballot me-2"></i> Completed Elections Results
                            </span>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                Check completed elections <strong>results</strong>.
                            </p>
                            <a class="btn btn-outline-primary" href="{{ route('election.completed.election') }}">
                                <i class="bi bi-plus-circle me-1"></i> Completed Elections
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Include the modal code from before -->
            <div class="modal fade" id="createElectionModal" tabindex="-1" aria-labelledby="createElectionLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="createElectionLabel">Create Election</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form id="electionForm" method="POST" action="{{ route('election.officer.save.election') }}">
                                @csrf
                                <!-- Election Name -->
                                <div class="mb-3">
                                    <label for="electionName" class="form-label">Election Name</label>
                                    <input type="text" class="form-control" id="electionName"
                                        placeholder="Enter election name" name="election_name">
                                </div>

                                <!-- Date -->
                                <div class="mb-3">
                                    <label for="electionDate" class="form-label">Election Date</label>
                                    <input type="date" class="form-control" id="electionDate" name="election_date">
                                </div>

                                <!-- Voting Period -->
                                <div class="row g-3 mb-3">
                                    <div class="col">
                                        <label for="startDate" class="form-label">Start Time & Date</label>
                                        <input type="datetime-local" class="form-control" id="startDate" name="start_time">
                                    </div>
                                    <div class="col">
                                        <label for="endDate" class="form-label">End Time & Date</label>
                                        <input type="datetime-local" class="form-control" id="endDate" name="end_time">
                                    </div>
                                </div>

                                <!-- Candidates -->
                                <div class="mb-3">
                                    <label for="candidates" class="form-label">Assign Candidates</label>
                                    <select multiple id="candidates" class="form-select" name="candidates[]">

                                    </select>
                                    <small class="text-muted">Each candidate will be linked to a position.</small>
                                </div>

                                <!-- Positions -->
                                <div class="mb-3">
                                    <label class="form-label">Positions</label>
                                    <div id="positionsWrapper">
                                        <div class="input-group mb-2">
                                            <select multiple class="form-select" name="positions[]">
                                                <option value="" disabled selected>Select a position</option>
                                                <option value="voter">Voter</option>
                                                <option value="election_officer">Election Officer</option>
                                                <option value="admin">Admin</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- DEpartment -->
                                <div class="mb-3" style="width:100%;">
                                    <label for="eligibleVoters" class="form-label">Department</label>
                                    <select multiple class="form-select" id="departments" name="departments[]">

                                    </select>
                                    <small class="text-muted">Hold Ctrl (Windows) / Cmd (Mac) to select multiple.</small>
                                </div>


                                <!-- Voters -->
                                <div class="mb-3">
                                    <label class="form-label">Voters</label>
                                    <div id="votersWrapper">
                                        <div class="input-group mb-2">
                                            <select multiple class="form-select" id="voters" name="voters[]">

                                            </select>
                                        </div>
                                    </div>
                                    <small class="text-muted">Hold Ctrl (Windows) / Cmd (Mac) to select multiple
                                        voters.</small>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" form="electionForm" class="btn btn-primary">Save
                                        Election</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>



                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajax({
                type: "get",
                url: "{{ route('election.officer.get.candidates') }}",
                success: function(response) {
                    let candidates = response.candidates;
                    let candidatesSelect = $('#candidates');
                    candidatesSelect.empty();
                    candidates.forEach(function(candidate) {
                        let option = $('<option></option>')
                            .attr('value', candidate.id)
                            .text(candidate.first_name + ' ' + candidate.last_name);
                        candidatesSelect.append(option);
                    });
                }
            });

            $.ajax({
                type: "GET",
                url: "{{ route('department.all.department') }}",
                success: function(response) {
                    let departments = response.departments ?? response;
                    let departmentsSelect = $('#departments');

                    departmentsSelect.empty();

                    departments.forEach(function(department) {
                        departmentsSelect.append(
                            $('<option></option>')
                            .val(department.id)
                            .text(department.department_name)
                        );
                    });


                }
            });


            $.ajax({
                type: "get",
                url: "{{ route('election.officer.get.voters') }}",
                success: function(response) {
                    let voters = response.voters;
                    let votersSelect = $('#voters');
                    votersSelect.empty();
                    voters.forEach(function(voter) {
                        let option = $('<option></option>')
                            .attr('value', voter.id)
                            .text(voter.first_name + ' ' + voter.last_name);
                        votersSelect.append(option);
                    });
                }
            });

            $('#electionForm').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();
                const URL = $(this).attr('action');
                addElection(formData, URL);

            });

            function addElection(formData, URL) {

                $.ajax({
                    type: "post",
                    url: URL,
                    data: formData,
                    success: function(response) {
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
            }
        })
    </script>
@endsection
