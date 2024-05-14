<!DOCTYPE html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="Negocios CRIMO S.A.C., Jaén, Cajamarca" />
    <meta name="description" content="Sistema para la empresa Negocios CRIMO S.A.C." />
    <meta name="robots" content="noindex,nofollow" />
    <title>Negocios CRIMO S.A.C.</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}" />
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
    @stack('css')
</head>

@auth

<body>
    <div class="preloader d-print-none">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full" class="d-print-none">
        <x-navigation-header />
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <x-navigation-menu />
            </div>
        </aside>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        @yield('navigation')
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <main class="row">
                    <div class="col-12">
                        <div class="card">
                            @yield('content')
                        </div>
                    </div>
                </main>
                <x-footer />
            </div>
        </div>
    </div>
    @yield('impresion')
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    @stack('js')
</body>
@endauth

@guest
@include('page.401')
@endguest

</html>