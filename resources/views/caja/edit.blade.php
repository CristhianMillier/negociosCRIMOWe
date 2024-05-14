@extends('template')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" />
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
<h2 class="page-title ">Generar Comprobante</h2>
<div class="ms-auto text-end">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cajas.index') }}">Ventas a cobrar</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Generar Comprobante
            </li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container w-100 mt-4 form-group">
    <form action="{{ route('cajas.update', ['caja'=>$venta]) }}" method="post">
        @method('PATCH')
        @csrf
        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                    <input type="text" class="form-control" value="Cliente:" disabled>
                </div>
            </div>
            <div class="col-sm-8">
                <input type="text" class="form-control" value="{{$venta->cliente->razon_social}}" disabled>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                    <input type="text" class="form-control" value="Fecha:" disabled>
                </div>
            </div>
            <div class="col-sm-8">
                <input type="text" class="form-control"
                    value="{{\Carbon\Carbon::parse($venta->fecha_hora)->format('d/m/Y')}}" disabled>
            </div>
            <?php
                use Carbon\Carbon;
                $fechaHora = Carbon::now()->toDateTimeString();
            ?>
            <input type="hidden" name="fecha_hora" value="{{$fechaHora}}">
        </div>

        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-ticket"></i></span>
                    <input type="text" class="form-control" value="Comprobante:" disabled>
                </div>
            </div>
            <div class="col-sm-8">
                <select name="comprobante_id" id="comprobante_id" class="select2 form-select shadow-none"
                    style="width: 100%; height: 36px">
                    <option value=""></option>
                    @foreach($comprobantes as $item)
                    <option value="{{ $item->id }}" {{ old('comprobante_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->nombre }}
                    </option>
                    @endforeach
                </select>
                @error('comprobante_id')
                <small class="text-danger">{{'*'.$message}}</small>
                @enderror
            </div>
        </div>

        <div class="card mb-4 border border-2">
            <div class="card-header">
                <i class="fa-solid fa-table"></i>
                Tabla de Detalle Venta
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered table-hover table-sm table-tighten">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white">Producto</th>
                            <th class="text-white">Cantidad</th>
                            <th class="text-white">Precio Venta</th>
                            <th class="text-white">Descuento</th>
                            <th class="text-white">SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($venta->productos as $item)
                        <tr>
                            <td>{{$item->descripcion}}</td>
                            <td>{{$item->pivot->cantidad}}</td>
                            <td>{{$item->pivot->precio_venta}}</td>
                            <td>{{$item->pivot->descuento}}</td>
                            <td>{{$item->pivot->cantidad * $item->pivot->precio_venta}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot style="background-color:#D7E1F3">
                        <tr>
                            <th></th>
                            <th colspan="3">Total</th>
                            <th colspan="1">
                                <input type="hidden" name="pago" value="{{$venta->total}}" id="inputPago">
                                <spam id="pago">{{$venta->total}}</span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div>
            <div class="border-top">
                <button type="submit" class="btn btn-outline-success mt-3">
                    Guardar
                </button>
                <a href="{{ route('cajas.index') }}"><button type="button" class="btn btn-outline-danger mt-3">
                        Cancelar
                    </button></a>
            </div>
        </div>
        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
    </form>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>

<script>
$(document).ready(function() {
    const li = document.getElementById("caja-li");
    li.classList.add("sidebar-item");
    li.classList.add("selected");
    const a = document.getElementById("caja-a");
    a.classList.add("sidebar-link");
    a.classList.add("waves-effect");
    a.classList.add("waves-dark");
    a.classList.add("active");

    $("#comprobante_id").select2({
        language: {
            noResults: function() {
                return "No hay resultado";
            },
            searching: function() {
                return "Buscando...";
            }
        },
        placeholder: 'Seleccione un Comprobante',
        theme: "classic",
        allowClear: true
    });
});
</script>
@endpush