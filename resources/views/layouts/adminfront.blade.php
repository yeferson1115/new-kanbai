<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Panel Alma de las cosas - @yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">
    <!-- Favicons -->
    <link href="{{ asset('images/kanbai-favicon.svg') }}" rel="icon">
    <link href="{{ asset('images/kanbai-favicon.svg') }}" rel="apple-touch-icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/system.css') }}">
    @stack('styles')
  </head>

  <body class="hold-transition login-page   login" id="body" >
    <!--Page Content Here -->
    @yield('content')

    <!-- REQUIRED JS SCRIPTS -->
    
    <!-- BEGIN: Vendor JS-->
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
    <!-- END: Theme JS-->



    <script src="{{ asset('assets/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery.validate.min.js') }}"></script>

    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

     <!-- BEGIN: Page JS-->
     <script src="{{ asset('app-assets/js/scripts/pages/app-invoice.js') }}"></script>

     <script src="{{ asset('app-assets/js/sweetalert2@9.js') }}"></script>
     <!-- END: Page JS-->

     <script>
      
        function _alertGeneric(type,title,text,reload=null){
            Swal.fire({
                //icon: type,
                icon: type,
                title: title,
                text: text,
                confirmButtonText:'Aceptar'
            }).then((result) => {
                //$('#page-loader').fadeOut(100);
                if(reload!='' && reload!=null && reload!=1){
                window.location.href = reload;
                }
                if(reload===1){
                location.reload();
                }
                if(reload===2){
                    window.history.go(-1);
                }
            });
        }



      


    </script>
   
    @stack('scripts')

    
  </body>

</html>
