@extends('template')

@push('css')
<style>
#customControlValidation1 {
    cursor: pointer;
}

#customControlValidation2 {
    cursor: pointer;
}
</style>
@endpush

@section('navigation')
<h2 class="page-title ">Crear Proveedor</h2>
<div class="ms-auto text-end">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Crear Proveedor
            </li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('proveedores.store') }}" method="post">
        @csrf
        <div class="form-group row">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="documento_id" class="form-label">Tipo Documento:</label>
                    <select name="documento_id" id="documento_id" class="form-select"
                        style="height: 36px; width: 100%; cursor: pointer;" onchange="limpiarNumDoc()"
                        autocomplete="off">
                        @foreach($tipo_documentos as $item)
                        <option value="{{ $item->id }}" {{ old('documento_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="num_documento" class="form-label">Número Documento:</label>
                    </br>
                    <div class="btn-group" role="group">
                        <input type="number" name="num_documento" id="num_documento" class="form-control"
                            oninput="limitarCaracteres()" value="{{ old('num_documento') }}" autocomplete="off">
                        <button type="button" class="btn btn-info" style="margin-left: 10px"
                            onclick="buscarDocumento()">Buscar</button>
                    </div>
                    <small class="text-danger" style="display:none" id="errorDNI">No se encontraron resultados del
                        documento ingresado</small>
                    @error('num_documento')
                    </br>
                    <small class=" text-danger">{{'*'.$message}}</small>
                    <script>
                    const doc = document.getElementById("num_documento");
                    doc.classList.add("form-control");
                    doc.classList.add("is-invalid");
                    </script>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="razon_social" class="form-label" id="label_razon">Nombre y Apellido:</label>
                    <input type="text" name="razon_social" id="razon_social" class="form-control" maxlength="150"
                        value="{{old('razon_social')}}" autocomplete="off">
                    @error('razon_social')
                    <small class="text-danger">{{'*'.$message}}</small>
                    <script>
                    const razon = document.getElementById("razon_social");
                    razon.classList.add("form-control");
                    razon.classList.add("is-invalid");
                    </script>
                    @enderror
                </div>
                <div class=" col-md-6">
                    <label for="direccion" class="form-label">Dirección:</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" maxlength="80"
                        value="{{old('direccion')}}" autocomplete="off">
                    @error('direccion')
                    <small class="text-danger">{{'*'.$message}}</small>
                    <script>
                    const direcc = document.getElementById("direccion");
                    direcc.classList.add("form-control");
                    direcc.classList.add("is-invalid");
                    </script>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Celular:</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" maxlength="11"
                        placeholder="000-000-000" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" value="{{old('telefono')}}"
                        autocomplete="off">
                    @error('telefono')
                    <small class="text-danger">{{'*'.$message}}</small>
                    <script>
                    const tel = document.getElementById("telefono");
                    tel.classList.add("form-control");
                    tel.classList.add("is-invalid");
                    </script>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="estado" class="form-label">Estado:</label>
                    <select name="estado" id="estado" class="form-select"
                        style="height: 36px; width: 100%; cursor: pointer;" autocomplete="off">
                        <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>ACTIVO</option>
                        <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>INACTIVO
                        </option>
                    </select>
                </div>
                <div>
                    <div class="border-top">
                        <button type="submit" class="btn btn-outline-success mt-3">
                            Guardar
                        </button>
                        <a href="{{ route('proveedores.index') }}"><button type="button"
                                class="btn btn-outline-danger mt-3">
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
<script>
$(document).ready(function() {
    const li = document.getElementById("proveedore-li");
    li.classList.add("sidebar-item");
    li.classList.add("selected");
    const a = document.getElementById("proveedore-a");
    a.classList.add("sidebar-link");
    a.classList.add("waves-effect");
    a.classList.add("waves-dark");
    a.classList.add("active");

    document.getElementById('telefono').addEventListener('input', function(e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
    });

    $("#razon_social").on("keypress", function() {
        var $input = $(this);
        setTimeout(function() {
            $input.val($input.val().toUpperCase());
        }, 50);
    });

    $("#direccion").on("keypress", function() {
        var $input = $(this);
        setTimeout(function() {
            $input.val($input.val().toUpperCase());
        }, 50);
    });
});

function buscarDocumento() {
    var tipo = $('#documento_id').val();
    var numero = $('#num_documento').val();

    if (tipo === '1') {
        $.ajax({
            type: "GET",
            url: '/consultar-dni/' + numero,
            success: function(response) {
                if (response.error === 'Error al consultar el DNI') {
                    document.getElementById("errorDNI").style.display = 'block';
                } else {
                    $('#razon_social').val(response.nombre + " " + response.apellido_paterno + " " +
                        response.apellido_materno);
                    document.getElementById("errorDNI").style.display = 'none';
                }
            },
            error: function(error) {
                document.getElementById("errorDNI").style.display = 'block';
            }
        });
    } else if (tipo === '2') {
        $.ajax({
            type: "GET",
            url: '/consultar-ruc/' + numero,
            success: function(response) {
                if (response.error === 'Error al consultar el RUC') {
                    document.getElementById("errorDNI").style.display = 'block';
                } else {
                    $('#razon_social').val(response.razonSocial);
                    if (response.direccion !== '-') {
                        $('#direccion').val(response.direccion);
                    }
                    document.getElementById("errorDNI").style.display = 'none';
                }
            },
            error: function(error) {
                document.getElementById("errorDNI").style.display = 'block';
            }
        });
    }
}

function limpiarNumDoc() {
    var input = document.getElementById("num_documento");
    var input2 = document.getElementById("razon_social");
    var input3 = document.getElementById("direccion");
    input.value = "";
    input2.value = "";
    input3.value = "";

    var select = document.getElementById("documento_id");
    var label = document.getElementById("label_razon");
    if (select.value === "1") {
        label.innerHTML = 'Nombre y Apellido:';
    } else if (select.value === "2") {
        label.innerHTML = 'Razon Social:';
    }
}

function limitarCaracteres() {
    var select = document.getElementById("documento_id");
    var input = document.getElementById("num_documento");
    if (select.value === "1") {
        if (input.value.length > 8) {
            input.value = input.value.slice(0, 8);
        }
    } else if (select.value === "2") {
        if (input.value.length > 11) {
            input.value = input.value.slice(0, 11);
        }
    }
}
</script>
@endpush