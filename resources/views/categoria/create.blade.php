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
<h2 class="page-title ">Crear Categoría</h2>
<div class="ms-auto text-end">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}">Categorías</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Crear Categoría
            </li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('categorias.store') }}" method="post">
        @csrf
        <div class="form-group row">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" maxlength="30"
                        value="{{old('nombre')}}" autocomplete="off">
                    @error('nombre')
                    <small class="text-danger">{{'*'.$message}}</small>
                    <script>
                    const razon = document.getElementById("nombre");
                    razon.classList.add("form-control");
                    razon.classList.add("is-invalid");
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
                        <a href="{{ route('categorias.index') }}"><button type="button"
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
    const li = document.getElementById("categoria-li");
    li.classList.add("sidebar-item");
    li.classList.add("selected");
    const a = document.getElementById("categoria-a");
    a.classList.add("sidebar-link");
    a.classList.add("waves-effect");
    a.classList.add("waves-dark");
    a.classList.add("active");

    $("#nombre").on("keypress", function() {
        var $input = $(this);
        setTimeout(function() {
            $input.val($input.val().toUpperCase());
        }, 50);
    });
});
</script>
@endpush