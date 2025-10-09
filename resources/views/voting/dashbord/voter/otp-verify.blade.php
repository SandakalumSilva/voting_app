@extends('voting.dashbord.layouts.app')
@section('content')
    <main class="content">
        <div class="container-fluid py-4">

            <!-- Danger Zone -->
            <div class="row g-3 mt-1" id="danger">
                <div class="col-12">
                    <div class="card shadow-sm danger-zone">
                        <div class="card-header bg-white">
                            <span class="fw-semibold">
                                Add Voting OTP</span>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"> <strong>Add your voting OTP here</strong> </p>
                            <form id="electionForm" method="POST" action="{{ route('voting.otp.verify.post') }}">
                                @csrf
                                <input type="hidden" name="voter_id" value="{{ $id }}">
                                <input name="otp" value="{{ old('otp') }}" id="profileName" class="form-control m-2"
                                    placeholder="1234" />
                                <button type="submit" class="btn btn-outline-primary delete-account"
                                    data-bs-toggle="modal">
                                    Add OTP
                                </button>

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
        $("#electionForm").on("submit", function(e) {
            e.preventDefault();
            const form = $(this);
            const url = form.attr("action");
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(response) {
                    notyf.success(response.message);
                    window.location.href = "/voter";
                },
                error: function(xhr) {
                    notyf.error(xhr.responseJSON.message);
                }
            });
        });
    </script>
@endsection
