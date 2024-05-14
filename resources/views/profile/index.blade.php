@extends('template')

@push('css')

@endpush

@section('navigation')
<h2 class="page-title ">Perfil</h2>
<div class="ms-auto text-end">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Perfil
            </li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container w-100 mt-4 form-group">
    <form action="{{ route('profile.update', ['profile'=>$user]) }}" method="post">
        @method('PATCH')
        @csrf
        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input type="text" class="form-control" value="Nombre:" disabled>
                </div>
            </div>
            <div class="col-sm-8">
                <input disabled type="text" class="form-control" value="{{old('name', $user->name)}}">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input type="text" class="form-control" value="Correo Electrónico:" disabled>
                </div>
            </div>
            <div class="col-sm-8">
                <input type="email" class="form-control" name="email" id="email" value="{{old('email', $user->email)}}">
                @error('email')
                <small class="text-danger">{{'*'.$message}}</small>
                <script>
                const razon = document.getElementById("email");
                razon.classList.add("form-control");
                razon.classList.add("is-invalid");
                </script>
                @enderror
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="text" class="form-control" value="Contraseña:" disabled>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="btn-group" role="group">
                    <input type="password" name="password" id="password" class="form-control" maxlength="191"
                        autocomplete="off">
                    <button type="button" class="btn btn-dark btn-sm" onclick="mostrarPassword1()">
                        <i class="fas fa-eye-slash" style="cursor: pointer" id="verPassword1"></i>
                    </button>
                </div>
                @error('password')
                <small class="text-danger">{{'*'.$message}}</small>
                <script>
                const razon = document.getElementById("password");
                razon.classList.add("form-control");
                razon.classList.add("is-invalid");
                </script>
                @enderror
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                    <input type="text" class="form-control" value="Confirmar contraseña:" disabled>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="btn-group" role="group">
                    <input type="password" name="password_confirmar" id="password_confirmar" class="form-control"
                        maxlength="191" autocomplete="off">
                    <button type="button" class="btn btn-dark btn-sm" onclick="mostrarPassword2()">
                        <i class="fas fa-eye-slash" style="cursor: pointer" id="verPassword2"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class=" col-md-12 text-end border-top">
            <a href="{{ route('panel') }}"><button type="button" class="btn btn-outline-info mt-3">
                    Atras
                </button></a>
            <button type="submit" class="btn btn-outline-success mt-3">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
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
    icon: "success",
    title: "{{ session('success') }}"
});
@endif

function mostrarPassword1() {
    var password = document.getElementById('password');
    var icono = document.getElementById('verPassword1');
    if (password.type === "text") {
        password.type = "password";
        icono.classList = 'fas fa-eye-slash';
    } else {
        password.type = "text";
        icono.classList = 'fas fa-eye';
    }
}

function mostrarPassword2() {
    var password = document.getElementById('password_confirmar');
    var icono = document.getElementById('verPassword2');
    if (password.type === "text") {
        password.type = "password";
        icono.classList = 'fas fa-eye-slash';
    } else {
        password.type = "text";
        icono.classList = 'fas fa-eye';
    }
}
</script>
@endpush