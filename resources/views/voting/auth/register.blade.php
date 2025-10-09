<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .register-container {
            margin-top: 80px;
        }

        .register-card {
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="container register-container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="register-card">
                    <h3 class="text-center mb-4">Register</h3>
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="name" name="first_name"
                                value="{{ old('first_name') }}" placeholder="Enter first your name" />
                            @if ($errors->has('first_name'))
                                <div class="text-danger mt-2">
                                    @foreach ($errors->get('first_name') as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="name" name="last_name"
                                value="{{ old('last_name') }}" placeholder="Enter last your name" />
                            @if ($errors->has('last_name'))
                                <div class="text-danger mt-2">
                                    @foreach ($errors->get('last_name') as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ old('email') }}" placeholder="Enter email" />
                            @if ($errors->has('email'))
                                <div class="text-danger mt-2">
                                    @foreach ($errors->get('email') as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Department</label>

                            <select multiple class="form-select" id="departments" name="department">

                            </select>
                            @if ($errors->has('department'))
                                <div class="text-danger mt-2">
                                    @foreach ($errors->get('department') as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Student Id</label>
                            <input type="text" class="form-control" id="name" name="student_id"
                                value="{{ old('student_id') }}" placeholder="Enter your student id" />
                            @if ($errors->has('student_id'))
                                <div class="text-danger mt-2">
                                    @foreach ($errors->get('student_id') as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" name="profile_image"
                                placeholder="Enter password" />
                            @if ($errors->has('profile_image'))
                                <div class="text-danger mt-2">
                                    @foreach ($errors->get('profile_image') as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="" selected disabled>Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                            @if ($errors->has('gender'))
                                <div class="text-danger mt-2">
                                    @foreach ($errors->get('gender') as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter password" />
                            @if ($errors->has('password'))
                                <div class="text-danger mt-2">
                                    @foreach ($errors->get('password') as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                id="confirmPassword" placeholder="Confirm password" />
                            @if ($errors->has('confirm_password'))
                                <div class="text-danger mt-2">
                                    @foreach ($errors->get('confirm_password') as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            Register
                        </button>
                    </form>
                    <p class="text-center mt-3">
                        Already have an account? <a href="{{ route('login') }}">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
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
    </script>
</body>

</html>
