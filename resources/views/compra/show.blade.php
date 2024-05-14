@extends('template')

@push('css')
@endpush

@section('navigation')
<h2 class="page-title ">Ver Compra</h2>
<div class="ms-auto text-end">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Ver Compra
            </li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container w-100 mt-4 form-group">
    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                <input type="text" class="form-control" value="Tipo Comprobante:" disabled>
            </div>
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="{{$compra->comprobante->nombre}}" disabled>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                <input type="text" class="form-control" value="Número de Comprobante:" disabled>
            </div>
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="{{$compra->num_comprobante}}" disabled>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                <input type="text" class="form-control" value="Proveedor:" disabled>
            </div>
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="{{$compra->proveedore->razon_social}}" disabled>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-database"></i></span>
                <input type="text" class="form-control" value="Usuario que regitro compra:" disabled>
            </div>
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="{{$compra->user->name}}" disabled>
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
            <input type="text" class="form-control" value="{{\Carbon\Carbon::parse($compra->fecha)->format('d/m/Y')}}"
                disabled>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                <input type="text" class="form-control" value="Impuesto:" disabled>
            </div>
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="{{$compra->impuesto}}" disabled>
        </div>
    </div>

    <div class="card mb-4 border border-2">
        <div class="card-header">
            <i class="fa-solid fa-table"></i>
            Tabla de Detalle Compra
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered table-hover table-sm table-tighten">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-white">Producto</th>
                        <th class="text-white">Cantidad</th>
                        <th class="text-white">Precio Compra</th>
                        <th class="text-white">Precio Venta</th>
                        <th class="text-white">SubTotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compra->productos as $item)
                    <tr>
                        <td>{{$item->descripcion}}</td>
                        <td>{{$item->pivot->cantidad}}</td>
                        <td>{{$item->pivot->precio_compra}}</td>
                        <td>{{$item->pivot->precio_venta}}</td>
                        <td>{{$item->pivot->cantidad * $item->pivot->precio_compra}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot style="background-color:#D7E1F3">
                    <tr>
                        <th></th>
                        <th colspan="3">Total</th>
                        <th colspan="1">
                            <spam>{{$compra->total}}</span>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class=" col-md-12 text-end border-top">
        <a href="{{ route('compras.index') }}"><button type="button" class="btn btn-info mt-3">
                Atras
            </button></a>
    </div>
</div>
@endsection

@push('js')
@endpush