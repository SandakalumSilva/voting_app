{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            margin-top: 100px;
        }

        .login-card {
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-card">
                    <h3 class="text-center mb-4">Select Your Role</h3>
                    <div class="mb-3">
                        <label class="form-label">Login As</label>
                        <select class="selectpicker form-control" id="role-select" data-live-search="true"
                            title="Select User Type">
                            <option value="">Select Role</option>
                            <option value="voter">Voter</option>
                            <option value="officer">Election Officer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <script>
        $(document).ready(function() {          
            $('#role-select').on('change', function() {
                var selectedRole = $(this).val();

                if (selectedRole === 'voter') {
                    window.location.href = '{{ route('voter.login') }}';
                } else if (selectedRole === 'officer') {
                    window.location.href = '{{ route('officer.login') }}';
                } else if (selectedRole === 'admin') {
                    window.location.href = '{{ route('admin.login') }}';
                }

            });
        });
    </script>

</body>

</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Election System Access</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

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
</head>

<body>

    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 text-center">
                <h2 class="fw-bold text-primary">Online Election System</h2>
                <p class="text-muted">Secure & Transparent Voting Platform</p>
            </div>
        </div>

        <div class="row g-4 justify-content-center">

            <!-- Voter Registration -->
            <div class="col-md-4 col-sm-12">
                <div class="card-box">
                    <div class="icon-circle">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <h5 class="fw-bold">Voter Registration</h5>
                    <div data-role="voter-registration" id="" class="btn btn-custom role-selection">Register
                    </div>
                </div>
            </div>

            <!-- User Login -->
            <div class="col-md-4 col-sm-12">
                <div class="card-box">
                    <div class="icon-circle">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </div>
                    <h5 class="fw-bold">User Login</h5>
                    <div data-role="user-login" id="" class="btn btn-custom role-selection">Login</div>
                </div>
            </div>

            <!-- System Admin -->
            <div class="col-md-4 col-sm-12">
                <div class="card-box">
                    <div class="icon-circle">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <h5 class="fw-bold">System Admin</h5>
                    <div data-role="admin-login" id="" class="btn btn-custom role-selection">Admin Access</div>
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

                if (selectedRole === 'voter-registration') {
                    window.location.href = '{{ route('register') }}';
                } else if (selectedRole === 'user-login') {
                    window.location.href = '{{ route('user.login') }}';
                } else if (selectedRole === 'admin-login') {
                    window.location.href = '{{ route('admin.login') }}';
                }

            });
        });
    </script>

</body>

</html>
