@extends('voting.dashbord.layouts.app')
@section('content')
    <main class="content">
        <div class="container-fluid py-4">
            <!-- Filters Row -->
            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                <h1 class="h4 mb-0">Dashboard</h1>
                <div class="vr d-none d-sm-block"></div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="electionFilter" style="max-width: 220px;">
                        <option value="all">All Elections</option>
                        <option value="national">National</option>
                        <option value="state">State</option>
                        <option value="local">Local</option>
                        <option value="student">Student</option>
                    </select>
                    <select class="form-select form-select-sm" id="statusFilter" style="max-width: 180px;">
                        <option value="any">Any Status</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="active">Active</option>
                        <option value="closed">Closed</option>
                    </select>
                    <button class="btn btn-sm btn-outline-primary" id="resetFilters"><i
                            class="bi bi-arrow-counterclockwise me-1"></i> Reset</button>
                </div>
                <div class="ms-auto d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary"><i class="bi bi-download me-1"></i> Export</button>
                    <button class="btn btn-sm btn-outline-primary"><i class="bi bi-printer me-1"></i> Print</button>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row g-3 mt-1">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <span class="fw-semibold"><i class="bi bi-clock-history me-2"></i> Recent Activity</span>
                        </div>
                        <ul class="list-group list-group-flush" id="activityFeed"></ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
