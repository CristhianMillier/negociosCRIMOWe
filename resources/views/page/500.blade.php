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
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png" />
    <link href="../dist/css/style.min.css" rel="stylesheet" />
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="error-box">
            <div class="error-body text-center">
                <h1 class="error-title text-dark">500</h1>
                <h3 class="text-uppercase error-subtitle">
                    LA PÁGINA NO FUNCIONA !
                </h3>
                <p class="text-muted mt-4 mb-4">
                    PARECE ESTAR INTENTANDO ENCONTRAR SU CAMINO A CASA
                </p>
                <a href="{{route('login')}}"
                    class="btn btn-dark btn-rounded waves-effect waves-light mb-5 text-white">Negocios
                    CRIMO S.A.C.</a>
            </div>
        </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(".preloader").fadeOut();
    </script>
</body>

</html>