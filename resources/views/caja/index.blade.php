@extends('template')

@push('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<style>
.dataTables_paginate .paginate_button {
    padding: 0;
    margin-right: 10px;
}
</style>
@endpush

@section('navigation')
<h2 class="page-title ">Ventas a cobrar</h2>
<div class="ms-auto text-end">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Ventas a cobrar
            </li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="card-body">
    <h5 class="card-title mt-5"><i class="fa-solid fa-table-cells"></i> Tabla Ventas a Cobrar</h5>
    <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered table-hover table-sm table-tighten">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total S/.</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $item)
                <tr>
                    <td>
                        {{ $item->razon_social }}
                    </td>
                    <td>
                        <p class="fw-semibold mb-1">{{ \Carbon\Carbon::parse($item->fecha_hora)->format('d/m/Y') }}</p>
                        <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($item->fecha_hora)->format('H:i') }}</p>
                    </td>
                    <td>
                        {{ $item->total }}
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            @can('cobranza')
                            <form action=" {{ route('cajas.edit', ['caja'=>$item->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    Cobrar
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/libs/DataTables/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {
    $('#zero_config').DataTable({
        responsive: true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        "columns": [{},
            {}, {},
            {
                "orderable": false,
                "searchable": false
            }
        ]
    });

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
});
</script>
@endpush