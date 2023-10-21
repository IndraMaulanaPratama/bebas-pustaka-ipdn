<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title')</title>
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

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    @vite(['public/assets/admin/js/main.js', 'public/assets/admin/css/style.css'])
</head>

<body class="antialiased">

    <main>
        <div class="container">

            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <h1>@yield('code')</h1>
                <h2>@yield('message')</h2>
                <a class="btn" href="{{ route('/') }}">Kembali ke beranda</a>
                <img src="./assets/admin/img/not-found.svg" class="img-fluid py-5" alt="Page Not Found">
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                    {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
                </div>
            </section>

        </div>
    </main><!-- End #main -->


    {{-- <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
                <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">
                    @yield('code')
                </div>

                <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                    @yield('message')
                </div>
            </div>
        </div>
    </div> --}}
</body>

</html>
