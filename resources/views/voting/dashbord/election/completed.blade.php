@extends('voting.dashbord.layouts.app')
@section('content')
    <main class="content">
        <div class="container-fluid py-4">
            <h3>Completed Election Results</h3>
            <div>
                <table class="table" id="election-reults">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Election Name</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Results</th>
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
            const table = $('#election-reults').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('election.get.completed.election') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'election_name',
                        name: 'election_name'
                    },
                    {
                        data: 'election_date',
                        name: 'election_date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // $(document).on('click', '.view-election', function(e) {
            //     e.preventDefault();
            //     const id = $(this).data('id');
            //     alert(id);

            // });
        });
    </script>
@endsection
