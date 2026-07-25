<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Kanbai - @yield('title')</title>
    <meta name="description" content="En marcepets.com criamos con amor los mejores cachorros de diferentes razas. 'La vida es mejor con un gordit@ de 4 patitas'">
    <!-- Favicons -->
     <!-- Favicons -->
     <link href="{{ asset('images/kanbai-favicon.svg') }}" rel="icon">
    <link href="{{ asset('images/kanbai-favicon.svg') }}" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
    <!-- Vendor CSS Files -->
    <link href="{{ asset('app-assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('app-assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('app-assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('app-assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.css" integrity="sha512-MKxcSu/LDtbIYHBNAWUQwfB3iVoG9xeMCm32QV5hZ/9lFaQZJVaXfz9aFa0IZExWzCpm7OWvp9zq9gVip/nLMg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <!-- Template Main CSS File -->
    <link href="{{ asset('app-assets/css/style.css').'?'.rand() }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @livewireStyles
</head>

<body class="body-register">
    <!-- ======= Property Search Section ======= -->
    <div class="click-closed"></div>
    <!-- ======= Header/Navbar ======= -->
    <nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top header-dark header-register" >
        @include('layouts.partials.headerregister')
    </nav><!-- End Header/Navbar -->
    <main id="main">
        @yield('content')
    </main><!-- End #main -->
    <!-- ======= Footer ======= -->
    
   
    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>

    <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>

    <!-- END: Page Vendor JS-->



    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('assets/js/core/html2canvas.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('assets/js/core/app.js') }}"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Vendor JS Files -->
    <script src="{{ asset('app-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.js" integrity="sha512-1mDhG//LAjM3pLXCJyaA+4c+h5qmMoTc7IuJyuNNPaakrWT9rVTxICK4tIizf7YwJsXgDC2JP74PGCc7qxLAHw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('app-assets/js/alpinejs.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('app-assets/js/main.js') }}"></script>
    <link rel="stylesheet" href="node_modules/@splidejs/splide/dist/css/splide.min.css">
    <!-- or the reference on CDN -->
    
    <script src="{{ asset('app-assets/js/splide.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/sweetalert2@9.js') }}"></script>
    <script src="{{ asset('app-assets/js/intlTelInput.min.js') }}"></script>
    @livewireScripts
    <script>
    function _alertGeneric(type, title, text, reload = null) {
        Swal.fire({
            //icon: type,
            icon: type,
            title: title,
            text: text,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            //$('#page-loader').fadeOut(100);
            if (reload != '' && reload != null && reload != 1) {
                window.location.href = reload;
            }
            if (reload === 1) {
                location.reload();
            }
            if (reload === 2) {
                window.history.go(-1);
            }
        });
    }

    function _alertLogin(type, title, text, reload = null) {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7F00FF',
            cancelButtonColor: '#7d71ff',
            confirmButtonText: '¿No tienes una cuenta?',
            cancelButtonText: 'Intentar'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = reload;
            }
        })
    }
    </script>
    @stack('scripts')
</body>

</html>
