@extends('template')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" />
@endpush

@section('navigation')
<h2 class="page-title ">Editar Usuario</h2>
<div class="ms-auto text-end">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Editar Usuario
            </li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('users.update', ['user'=>$user]) }}" method="post">
        @method('PATCH')
        @csrf
        <div class="form-group row">
            <div class="row g-3">
                <div class="row mb-4 mt-4">
                    <label for="name" class="col-sm-2 col-form-label">Nombre:</label>
                    <div class="col-sm-4">
                        <input type="text" name="name" id="name" class="form-control" maxlength="191"
                            value="{{old('name', $user->name)}}" autocomplete="off">
                    </div>
                    <div class="col-sm-4">
                        <div class="form-text">
                            Escriba Apellido y Nombre
                        </div>
                    </div>
                    <div class="col-sm-2">
                        @error('name')
                        <small class="text-danger">{{'*'.$message}}</small>
                        <script>
                        const razon = document.getElementById("name");
                        razon.classList.add("form-control");
                        razon.classList.add("is-invalid");
                        </script>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="email" class="col-sm-2 col-form-label">Correo electrónico:</label>
                    <div class="col-sm-4">
                        <input type="email" name="email" id="email" class="form-control" maxlength="191"
                            value="{{old('email', $user->email)}}" autocomplete="off">
                    </div>
                    <div class="col-sm-4">
                        <div class="form-text">
                            Dirección de correo electrónico
                        </div>
                    </div>
                    <div class="col-sm-2">
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

                <div class="row mb-4">
                    <label for="password" class="col-sm-2 col-form-label">Contraseña:</label>
                    <div class="col-sm-4">
                        <div class="btn-group" role="group">
                            <input type="password" name="password" id="password" class="form-control" maxlength="191"
                                autocomplete="off">
                            <button type="button" class="btn btn-dark btn-sm" onclick="mostrarPassword1()">
                                <i class="fas fa-eye-slash" style="cursor: pointer" id="verPassword1"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-text">
                            Ingrese una contraseña segura
                        </div>
                    </div>
                    <div class="col-sm-2">
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
                    <label for="password_confirmar" class="col-sm-2 col-form-label">Confirmar
                        Contraseña:</label>
                    <div class="col-sm-4">
                        <div class="btn-group" role="group">
                            <input type="password" name="password_confirmar" id="password_confirmar"
                                class="form-control" maxlength="191" autocomplete="off">
                            <button type="button" class="btn btn-dark btn-sm" onclick="mostrarPassword2()">
                                <i class="fas fa-eye-slash" style="cursor: pointer" id="verPassword2"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-text">
                            Vuelva a ingresar la contraseña
                        </div>
                    </div>
                    <div class="col-sm-2">
                        @error('password_confirmar')
                        <small class="text-danger">{{'*'.$message}}</small>
                        <script>
                        const razon = document.getElementById("password_confirmar");
                        razon.classList.add("form-control");
                        razon.classList.add("is-invalid");
                        </script>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="role" class="col-sm-2 col-form-label">Seleccionar un Rol:</label>
                    <div class="col-sm-4">
                        <select name="role" id="role" class="js-example-placeholder-single js-states form-control"
                            style="width: 100%; height: 36px">
                            <option value=""></option>
                            @foreach($roles as $item)
                            @if (in_array($item->name, $user->roles->pluck('name')->toArray()))
                            <option selected value="{{ $item->name }}"
                                {{ old('role') == $item->name ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @else
                            <option value="{{ $item->name }}" {{ old('role') == $item->name ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-text">
                            Escoja el rol que se asignará al usuario
                        </div>
                    </div>
                    <div class="col-sm-2">
                        @error('role')
                        <small class="text-danger">{{'*'.$message}}</small>
                        <script>
                        const razon = document.getElementById("role");
                        razon.classList.add("form-control");
                        razon.classList.add("is-invalid");
                        </script>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="almacene_id" class="col-sm-2 col-form-label">Seleccionar un Almacen:</label>
                    <div class="col-sm-4">
                        <select name="almacene_id" id="almacene_id"
                            class="js-example-placeholder-single js-states form-control"
                            style="width: 100%; height: 36px">
                            <option value=""></option>
                            @foreach($almacenes as $item)
                            @if ($user->almacene_id == $item->id)
                            <option selected value="{{ $item->id }}"
                                {{ old('almacene_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->direccion.'-'.$item->distrito }}
                            </option>
                            @else
                            <option value="{{ $item->id }}" {{ old('almacene_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->direccion.'-'.$item->distrito }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-text">
                            Escoja el almacen que se asignará al usuario
                        </div>
                    </div>
                    <div class="col-sm-2">
                        @error('almacene_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                        <script>
                        const razon = document.getElementById("almacene_id");
                        razon.classList.add("form-control");
                        razon.classList.add("is-invalid");
                        </script>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="border-top">
                        <button type="submit" class="btn btn-outline-success mt-3">
                            Actualizar
                        </button>
                        <button type="reset" class="btn btn-outline-secondary mt-3">
                            Restaurar
                        </button>
                        <a href="{{ route('users.index') }}"><button type="button" class="btn btn-outline-danger mt-3">
                                Cancelar
                            </button></a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>

<script>
$(document).ready(function() {
    const li = document.getElementById("user-li");
    li.classList.add("sidebar-item");
    li.classList.add("selected");
    const a = document.getElementById("user-a");
    a.classList.add("sidebar-link");
    a.classList.add("waves-effect");
    a.classList.add("waves-dark");
    a.classList.add("active");

    $("#name").on("keypress", function() {
        var $input = $(this);
        setTimeout(function() {
            $input.val($input.val().toUpperCase());
        }, 50);
    });

    $("#role").select2({
        language: {
            noResults: function() {
                return "No hay resultado";
            },
            searching: function() {
                return "Buscando...";
            }
        },
        placeholder: 'Seleccione un Rol',
        theme: "classic",
        allowClear: true
    });

    $("#almacene_id").select2({
        language: {
            noResults: function() {
                return "No hay resultado";
            },
            searching: function() {
                return "Buscando...";
            }
        },
        placeholder: 'Seleccione un Almacen',
        theme: "classic",
        allowClear: true
    });
});

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