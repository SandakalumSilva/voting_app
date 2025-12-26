<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Login</title>

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Segoe UI", sans-serif;
        }

        .card-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-box:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .icon-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, #64b5f6, #1e88e5);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #ffffff;
            font-size: 40px;
        }

        .btn-custom {
            background-color: #1e88e5;
            color: #ffffff;
            border-radius: 30px;
            padding: 8px 24px;
        }

        .btn-custom:hover {
            background-color: #1565c0;
            color: #ffffff;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 text-center">
                <h2 class="fw-bold text-primary">User Login</h2>
            </div>
        </div>

        <div class="row g-4 justify-content-center">

            <!-- Voter Registration -->
            <div class="col-md-4 col-sm-12">
                <div class="card-box">
                    <div class="icon-circle">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <h5 class="fw-bold">Voter Login</h5>
                    <div data-role="voter-login" id="" class="btn btn-custom role-selection">Login
                    </div>
                </div>
            </div>

            <!-- User Login -->
            <div class="col-md-4 col-sm-12">
                <div class="card-box">
                    <div class="icon-circle">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </div>
                    <h5 class="fw-bold">Election Officer Login</h5>
                    <div data-role="election-officer-login" id="" class="btn btn-custom role-selection">Login
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.role-selection').on('click', function() {
                var selectedRole = $(this).data('role');
                // alert(selectedRole);

                if (selectedRole === 'voter-login') {
                    window.location.href = '{{ route('voter.login') }}';
                } else if (selectedRole === 'election-officer-login') {
                    window.location.href = '{{ route('officer.login') }}';
                }

            });
        });
    </script>

</body>

</html>
