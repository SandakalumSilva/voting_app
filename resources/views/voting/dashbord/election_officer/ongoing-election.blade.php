@extends('voting.dashbord.layouts.app')
@section('content')
    <main class="content">
        <div class="container-fluid py-4">
            <!-- KPI Row (voter-centric) -->
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-xl-3">
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
                <div class="col-12 col-sm-6 col-xl-3">
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
                <div class="col-12 col-sm-6 col-xl-3">
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
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-hover shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-muted small">Enrollment Requests</div>
                                    <div class="h3 mb-0" id="kpiRequests">—</div>
                                </div>
                                <span class="text-primary fs-3"><i class="bi bi-person-badge"></i></span>
                            </div>
                            <div class="text-muted small mt-2">Pending approval by admin</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
