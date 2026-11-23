<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Screen - Aplikasi Parkir</title>

    <meta name="description" content="Login Screen - Aplikasi Parkir">
    <meta name="author" content="Spark Admin Team">

    <link rel="icon" type="image/png" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="assets/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

    <div class="login-wrapper">
        <div class="login-bg-shape login-bg-shape-1"></div>
        <div class="login-bg-shape login-bg-shape-2"></div>

        <div class="login-card">

            <a href="{{ url('/') }}" class="login-brand text-decoration-none">
                <i class="bi bi-asterisk"></i>
                <span>Aplikasi Parkir</span>
            </a>

            <p class="login-subtitle">Mohon masukan akun anda terlebih dahulu</p>

            <form action="{{ route('aksi_login') }}" method="POST" id="loginForm" class="needs-validation">
                @csrf

                <div class="login-form-group">
                    <label for="username" class="login-form-label">Username</label>
                    <div class="login-input-group">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="text" id="username" name="username" class="login-input" placeholder="" required>
                    </div>
                </div>

                <div class="login-form-group">
                    <label for="password" class="login-form-label">Password</label>
                    <div class="login-input-group">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="login-input login-input-password" placeholder="••••••••" required>
                        <button type="button" class="password-toggle-btn" id="toggle-password" aria-label="Show password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login" id="btn-submit">
                    <span>Masuk ke Dashboard</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <p class="login-footer-text mt-2">
                Tidak punya akun? <a href="#" id="link-register">Hubungi admin</a>
            </p>

        </div>
    </div>

    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/auth.js"></script>
</body>
</html>
