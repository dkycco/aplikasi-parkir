<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Aplikasi Parkir</title>

  <meta name="description" content="Dashboard - Aplikasi Parkir">
  <meta name="author" content="Spark Admin Team">

  <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/apexcharts/apexcharts.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>
 
<body>
    @include('partials.sidebar') 
    <div class="main-wrapper">
        @include('partials.navbar')
        @yield('isi')

        <footer class="footer-custom">
        <div class="footer-left">
            <span class="footer-logo">
            <i class="bi bi-asterisk"></i> Aplikasi Parkir
            </span>
            <span class="footer-separator">|</span>
            <span class="footer-copy">&copy; 2026 Made with <i class="bi bi-heart-fill text-danger footer-heart"></i> by<a
                href="#" target="_blank">Team Aplikasi Parkir</a></span>
        </div>
        </footer>
    </div>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>