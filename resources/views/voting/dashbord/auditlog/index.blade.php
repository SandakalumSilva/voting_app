@extends('voting.dashbord.layouts.app')
@section('content')
    <main class="content">
        <div class="container-fluid py-4">
            <h3>Audit Logs</h3>
            <a href="{{ route('auditlog.download') }}" target="_blank" class="btn btn-sm btn-primary mb-1 mt-1">Download
                audit-logs</a>
            <div>
                <table class="table" id="audit-logs">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">User</th>
                            <th scope="col">Action</th>
                            <th scope="col">Date</th>
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
            const table = $('#audit-logs').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('auditlog.get') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ]
            })
        });
    </script>
@endsection
