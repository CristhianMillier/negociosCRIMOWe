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
<h2 class="page-title ">Usuarios</h2>
<div class="ms-auto text-end">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Usuarios
            </li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="card-body">
    @can('crear-usuario')
    <a href="{{ route('users.create') }}"><button type="button" class="btn btn-outline-info">Añadir nuevo
            Usuario</button></a>
    @endcan
    <h5 class="card-title mt-5"><i class="fa-solid fa-table-cells"></i> Tabla Usuarios</h5>
    <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered table-hover table-sm table-tighten">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Almacen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $item)
                <tr>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td>
                        {{ $item->email }}
                    </td>
                    <td>
                        {{ $item->getRoleNames()->first() }}
                    </td>
                    <td>
                        <p class="fw-semibold mb-1">{{ $item->almacene->direccion }}</p>
                        <p class="text-muted mb-0">{{ $item->almacene->distrito }} - {{ $item->almacene->provincia }} -
                            {{ $item->almacene->departamento }}
                        </p>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            @can('editar-usuario')
                            <form action=" {{ route('users.edit', ['user'=>$item]) }}">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">
                                    Editar
                                </button>
                            </form>
                            @endcan

                            @can('eliminar-usuario')
                            <button type="button" class="btn btn-danger btn-sm mr-3" style="margin-left: 10px"
                                data-bs-toggle="modal" data-bs-target="#confirmarModal-{{ $item->id }}">
                                Eliminar
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>

                @can('eliminar-usuario')
                <!-- Modal -->
                <div class="modal fade" id="confirmarModal-{{ $item->id }}" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">MENSAJE DE CONFIRMACIÓN...
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ¿SEGURO QUE QUIERES ELIMINAR EL USUARIO - {{ $item->name }}?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <form action=" {{ route('users.destroy', ['user'=>$item->id]) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger text-white">Confirmar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection @push('js')
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
        "columns": [{}, {}, {}, {},
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