<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Klinik</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            height: 100vh;
        }

        .login-card {
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .login-title {
            font-weight: bold;
            color: #4e73df;
        }

        .btn-login {
            background-color: #4e73df;
            border: none;
        }

        .btn-login:hover {
            background-color: #2e59d9;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center h-100">
    <div class="col-md-4">
        <div class="card login-card p-4">

            <div class="text-center mb-4">
                <h3 class="login-title">🏥 Klinik Sehat</h3>
                <p class="text-muted">Silakan login ke sistem</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-login text-white">
                        Login
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>