<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>VoteAdmin • Online Voting System Dashboard</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Notyf -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Select2 -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"> --}}

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        :root {
            --sidebar-width: 280px;
            /* Light blue theme tokens */
            --lp-bg: #eaf4fc;
            /* page background */
            --lp-surface: #ffffff;
            /* cards, navbar, modals */
            --lp-surface-2: #f0f8ff;
            /* sidebar */
            --lp-text: #03396c;
            /* main text */
            --lp-muted: #5b7aa2;
            /* muted text */
            --lp-primary: #4da3ff;
            /* primary */
            --lp-primary-strong: #1e90ff;
            /* hover/active */
            --lp-primary-subtle: #d6e9ff;
            /* subtle fills */

            /* Wire into Bootstrap vars where sensible */
            --bs-primary: var(--lp-primary);
            --bs-primary-rgb: 77, 163, 255;
            --bs-body-color: var(--lp-text);
            --bs-body-bg: var(--lp-bg);
            --bs-border-color: rgba(3, 57, 108, .15);
        }

        body {
            min-height: 100vh;
        }

        .navbar,
        .card,
        .offcanvas,
        .modal-content {
            background-color: var(--lp-surface);
        }

        .navbar {
            border-bottom: 1px solid var(--bs-border-color);
        }

        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--lp-surface-2);
        }

        .sidebar .nav-link {
            color: var(--lp-text);
        }

        .sidebar .nav-link.active {
            background: color-mix(in srgb, var(--lp-primary) 12%, transparent);
            border-left: 3px solid var(--lp-primary);
            color: var(--lp-primary);
        }

        .content {
            margin-left: 0;
        }

        @media (min-width: 992px) {
            .content {
                margin-left: var(--sidebar-width);
            }

            .sidebar {
                position: fixed;
                top: 56px;
                bottom: 0;
                left: 0;
                padding: 1rem;
                overflow-y: auto;
                border-right: 1px solid var(--bs-border-color);
            }
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .08);
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--lp-primary-subtle);
            color: var(--lp-primary);
            font-weight: 600;
            font-size: .85rem;
        }

        .text-muted {
            color: var(--lp-muted) !important;
        }

        .btn-primary {
            background-color: var(--lp-primary);
            border-color: var(--lp-primary);
        }

        .btn-primary:hover {
            background-color: var(--lp-primary-strong);
            border-color: var(--lp-primary-strong);
        }

        .progress-bar {
            background-color: var(--lp-primary);
        }
    </style>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



</head>

<body class="bg-body-tertiary">
    <!-- Top Navbar -->
    @include('voting.dashbord.layouts.navbar')

    <!-- Sidebar Offcanvas -->
    @include('voting.dashbord.layouts.sidebar')
    <!-- Main Content -->
    @yield('content')



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Notyf -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <!-- NProgress -->
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- Select2 -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var notyf = new Notyf({
            duration: 5000
        });
    </script>


    @yield('scripts')

    <script>
        $(".sign-out").on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, sign out!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        url: "/logout",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            
                            setTimeout(() => window.location.href =
                                "{{ route('login') }}", 450);
                        },
                        error: function(xhr) {
                            notyf.error(xhr.responseJSON.message ||
                                'An error occurred.');
                        }

                    });
                }
            })




        });
    </script>

</body>

</html>
