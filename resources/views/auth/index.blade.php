<!DOCTYPE html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="Representaciones Flores, Jaén, Cajamarca" />
    <meta name="description" content="Sistema para la Representaciones Flores" />
    <meta name="robots" content="noindex,nofollow" />
    <title>Representaciones Flores E.I.R.L</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png" />
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="contenido">
        <form method="POST" action="/login">
            @csrf
            <div class="logeo">
                <img src="{{ asset('assets/images/logo-icon.png') }}" alt="70" width="170" />
                <h1>BIENVENIDO AL SISTEMA</h1>
            </div>
            <div class="cont">
                <label>CORREO ELECTRÓNICO:</label>
                <input type="text" name="email" class="text" autocomplete="off" autofocus value="{{old('email')}}">
                <i class="fas fa-eye-slash" style="color: #0e181e"></i>
            </div>
            <div class="cont separator">
                <label>CONTRASEÑA:</label>
                <input type="password" name="password" class="text" autocomplete="off" id="password">
                <i class="fas fa-eye-slash" style="cursor: pointer" id="verPassword" onclick="mostrarPassword()"></i>
            </div>
            <button type="submit" class="boton">INGRESAR</button>
        </form>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@error('email')
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});
Toast.fire({
    icon: "warning",
    title: "{{$message}}"
});
@enderror

@error('password')
const Toast2 = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});
Toast2.fire({
    icon: "warning",
    title: "{{$message}}"
});
@enderror

@if(session('success'))
const Toast3 = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});
Toast3.fire({
    icon: "error",
    title: "{{ session('success') }}"
});
@endif

function mostrarPassword() {
    var password = document.getElementById('password');
    var icono = document.getElementById('verPassword');
    if (password.type === "text") {
        password.type = "password";
        icono.classList = 'fas fa-eye-slash';
    } else {
        password.type = "text";
        icono.classList = 'fas fa-eye';
    }
}
</script>

</html>