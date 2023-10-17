<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ $title ?? 'Perpustakaan IPDN' }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="./assets/admin/img/favicon.png" rel="icon">
    <link href="./assets/admin/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="./assets/admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/admin/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="./assets/admin/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="./assets/admin/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="./assets/admin/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="./assets/admin/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="./assets/admin/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    {{-- <link href="./assets/admin/css/style.css" rel="stylesheet"> --}}

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

    @vite(['public/assets/admin/js/main.js', 'public/assets/admin/css/style.css'])
</head>

<body>

    <!-- ======= Header ======= -->
    <x-admin.tamplates.admin-navbar />
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <x-admin.tamplates.admin-sidebar />

    <!-- End Sidebar-->

    <main id="main" class="main">

        <!-- Page Title -->
        <x-admin.tamplates.admin-pageTitle />
        <!-- End Page Title -->

        <section class="section dashboard">
            {{ $slot }}
            {{--  // TODO: Buatkan module similaritas --}}
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <x-admin.tamplates.admin-footer />
    <!-- End Footer -->


    <!-- Vendor JS Files -->
    <script src="./assets/admin/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="./assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/admin/vendor/chart.js/chart.umd.js"></script>
    <script src="./assets/admin/vendor/echarts/echarts.min.js"></script>
    <script src="./assets/admin/vendor/quill/quill.min.js"></script>
    <script src="./assets/admin/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="./assets/admin/vendor/tinymce/tinymce.min.js"></script>
    <script src="./assets/admin/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    {{-- <script src="./assets/admin/js/main.js"></script> --}}

</body>

</html>
