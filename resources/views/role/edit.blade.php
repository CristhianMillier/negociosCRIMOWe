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
<h2 class="page-title ">Editar Rol</h2>
<div class="ms-auto text-end">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Editar Rol
            </li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('roles.update', ['role'=>$role]) }}" method="post">
        @method('PATCH')
        @csrf
        <div class="form-group row">
            <div class="row g-3">
                <div class="row mb-4">
                    <label for="name" class="col-sm-2 col-form-label">Nombre del Rol:</label>
                    <div class="col-sm-4">
                        <input type="text" name="name" id="name" class="form-control" maxlength="30"
                            value="{{old('name', $role->name)}}" autocomplete="off">
                    </div>
                    <div class="col-sm-6">
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

                <div class="col-12 mb-4">
                    <label for="" class="form-label">Permisos para el Rol:</label>
                    @foreach ($permisos as $item)
                    @if (in_array($item->id, $role->permissions->pluck('id')->toArray()))
                    <div class="form-check mb-2">
                        <input checked type="checkbox" name="permission[]" id="{{$item->id}}" class="form-check-input"
                            value="{{$item->id}}">
                        <label for="{{$item->id}}" class="form-check-label">{{$item->name}}</label>
                    </div>
                    @else
                    <div class="form-check mb-2">
                        <input type="checkbox" name="permission[]" id="{{$item->id}}" class="form-check-input"
                            value="{{$item->id}}">
                        <label for="{{$item->id}}" class="form-check-label">{{$item->name}}</label>
                    </div>
                    @endif
                    @endforeach
                </div>
                @error('permission')
                <small class="text-danger">{{'*'.$message}}</small>
                @enderror

                <div>
                    <div class="border-top">
                        <button type="submit" class="btn btn-outline-success mt-3">
                            Actualizar
                        </button>
                        <button type="reset" class="btn btn-outline-secondary mt-3">
                            Restaurar
                        </button>
                        <a href="{{ route('roles.index') }}"><button type="button" class="btn btn-outline-danger mt-3">
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
    const li = document.getElementById("role-li");
    li.classList.add("sidebar-item");
    li.classList.add("selected");
    const a = document.getElementById("role-a");
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
});
</script>
@endpush