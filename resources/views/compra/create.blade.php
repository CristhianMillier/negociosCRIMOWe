@extends('template')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" />
@endpush

@section('navigation')
<h2 class="page-title ">Crear Compra</h2>
<div class="ms-auto text-end">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Crear Compra
            </li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container mt-4">
    <form action="{{ route('compras.store') }}" method="post">
        @csrf
        <div class="form-group row gy-4">
            <!-- Producto -->
            <div class="col-md-4">
                <div class="text-white bg-success p-1 text-center">
                    Datos Generales
                </div>
                <div class="p-3 border border-3 border-success">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="proveedore_id" class="form-label">Proveedor:</label>
                            <select name="proveedore_id" id="proveedore_id" class="select2 form-select shadow-none"
                                style="width: 100%; height: 36px">
                                <option value=""></option>
                                @foreach($proveedores as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('proveedore_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->razon_social }}
                                </option>
                                @endforeach
                            </select>
                            @error('proveedore_id')
                            <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="comprobante_id" class="form-label">Comprobante:</label>
                            <select name="comprobante_id" id="comprobante_id" class="select2 form-select shadow-none"
                                style="width: 100%; height: 36px">
                                <option value=""></option>
                                @foreach($comprobantes as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('comprobante_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre }}
                                </option>
                                @endforeach
                            </select>
                            @error('comprobante_id')
                            <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="num_comprobante" class="form-label">Número de Comprobante:</label>
                            <input type="text" name="num_comprobante" id="num_comprobante" class="form-control"
                                maxlength="250" autocomplete="off" value="{{old('num_comprobante')}}" required>
                            @error('num_comprobante')
                            <small class="text-danger">{{'*'.$message}}</small>
                            <script>
                            const razon = document.getElementById("num_comprobante");
                            razon.classList.add("form-control");
                            razon.classList.add("is-invalid");
                            </script>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="impuesto" class="form-label">Impuesto:</label>
                            <select name="impuesto" id="impuesto" class="form-select"
                                style="height: 36px; width: 100%; cursor: pointer;">
                                <option value="0" {{ old('impuesto') == 0 ? 'selected' : '' }}>
                                    0 %
                                </option>
                                <option value="18" {{ old('impuesto') == 18 ? 'selected' : '' }}>
                                    18 %
                                </option>
                            </select>
                            @error('impuesto')
                            <small class="text-danger">{{'*'.$message}}</small>
                            <script>
                            const razon = document.getElementById("impuesto");
                            razon.classList.add("form-control");
                            razon.classList.add("is-invalid");
                            </script>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="fecha" class="form-label">Fecha:</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" autocomplete="off"
                                value="{{ old('fecha', date('Y-m-d')) }}" readonly>
                            @error('fecha')
                            <small class="text-danger">{{'*'.$message}}</small>
                            <script>
                            const razon = document.getElementById("fecha");
                            razon.classList.add("form-control");
                            razon.classList.add("is-invalid");
                            </script>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-2 text-center">
                            <div class="border-top">
                                <button type="submit" class="btn btn-outline-success mt-3" id="guardar">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compra Producto -->
            <div class="col-md-8">
                <div class="text-white bg-primary p-1 text-center">
                    Detalles de la compra
                </div>
                <div class="p-3 border border-3 border-primary">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <select name="producto_id" id="producto_id" class="select2 form-select shadow-none"
                                style="width: 100%; height: 36px">
                                <option value=""></option>
                                @foreach($productos as $item)
                                <option value=" {{ $item->id }}"
                                    {{ old('producto_id') == $item->id ? 'selected' : '' }}>
                                    {{$item->descripcion.'-'.$item->codigo_producto.'-'.$item->marca->nombre.'-'.$item->procedencia }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control" autocomplete="off"
                                value="{{old('cantidad')}}" step="1">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="precio_compra" class="form-label">Precio Compra:</label>
                            <div class="input-group">
                                <input type="number" name="precio_compra" id="precio_compra" class="form-control"
                                    autocomplete="off" value="{{old('precio_compra')}}" step="0.1">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">S/</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="precio_venta" class="form-label">Precio Venta:</label>
                            <div class="input-group">
                                <input type="number" name="precio_venta" id="precio_venta" class="form-control"
                                    autocomplete="off" value="{{old('precio_venta')}}" step="0.1">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">S/</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2 text-end">
                            <button type="button" id="agregar" class="btn btn-outline-info mt-3"
                                onclick="agregarProductos()">
                                Agregar
                            </button>
                        </div>
                        <div class="col-md-12">
                            <div class="border-top">
                                <div class="table-responsive mt-3">
                                    <table id="tabla"
                                        class="table table-striped table-bordered table-hover table-sm table-tighten">
                                        <thead class="bg-info">
                                            <tr>
                                                <th class="text-white">Producto</th>
                                                <th class="text-white">Cantidad</th>
                                                <th class="text-white">Compra</th>
                                                <th class="text-white">Venta</th>
                                                <th class="text-white">Sub Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot style="background-color:#D7E1F3">
                                            <tr>
                                                <th></th>
                                                <th colspan="3">Total</th>
                                                <th colspan="2">
                                                    <input type="hidden" name="total" value="0" id="inputTotal">
                                                    <spam id="total">0</span>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" id="cancelar">
                            Cancelar Detalle Compra
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
    </form>

    <!-- Modal Cancelar Compra -->
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CONFIRMACIÓN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿SEGURO QUE QUIERES CANCELAR EL DETALLE DE COMPRA?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        onclick="cancelarCompra()">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    disableButtons();

    $("#proveedore_id").select2({
        language: {
            noResults: function() {
                return "No hay resultado";
            },
            searching: function() {
                return "Buscando...";
            }
        },
        placeholder: 'Seleccione un Proveedor',
        theme: "classic",
        allowClear: true
    });

    $("#producto_id").select2({
        language: {
            noResults: function() {
                return "No hay resultado";
            },
            searching: function() {
                return "Buscando...";
            }
        },
        placeholder: 'Seleccione un Producto',
        theme: "classic",
        allowClear: true
    });

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

    const precioCompraInput = document.getElementById("precio_compra");
    const precioVentaInput = document.getElementById("precio_venta");

    precioCompraInput.addEventListener("input", () => {
        const precioCompra = parseFloat(precioCompraInput.value);
        const precioVenta = precioCompra * 1.3;
        precioVentaInput.value = round(precioVenta);
    });
});

function limitarCaracteres() {
    var input = document.getElementById("impuesto");
    if (input.value.length > 2) {
        input.value = input.value.slice(0, 2);
    }
}

let total = 0;

function agregarProductos() {
    var select = document.getElementById("producto_id");
    var idProd = select.value.trim();
    const selectedOption = select.options[select.selectedIndex];
    var nameProducto = selectedOption.text.split("-")[0].trim();
    var cantidad = $('#cantidad').val();
    var compra = $('#precio_compra').val();
    var venta = $('#precio_venta').val();

    if (nameProducto !== '' && cantidad !== '' && compra !== '' && venta !== '') {
        if (parseInt(cantidad) > 0 && (cantidad % 1 == 0) && parseFloat(compra) > 0 && parseFloat(venta) > 0) {
            if (parseFloat(venta) > parseFloat(compra)) {
                if (!existeProductoEnTabla(idProd)) {
                    let fila = '<tr id="fila' + idProd + '">' +
                        '<th><input type="hidden" name="arrayidproducto[]" value="' +
                        idProd + '">' + nameProducto + '</th>' +
                        '<th><input type="hidden" name="arraycantidad[]" value="' +
                        cantidad + '">' + cantidad + '</th>' +
                        '<th><input type="hidden" name="arraycompra[]" value="' +
                        compra + '">' + compra + '</th>' +
                        '<th><input type="hidden" name="arrayventa[]" value="' +
                        venta + '">' + venta + '</th>' +
                        '<th>' + (cantidad * compra) + '</th>' +
                        '<th><button class="btn btn-danger" onClick="eliminarProducto(' + idProd +
                        ')" type="button"><i class="fa-solid fa-trash"></i></button></th>' +
                        '</tr>';

                    $('#tabla').append(fila);
                    limpiarCampos();

                    total += (cantidad * compra);
                    $('#total').html(total);
                    $('#inputTotal').val(total);
                    disableButtons();
                } else {
                    showModal('El producto ya existe en la tabla');
                }
            } else {
                showModal('El precio de venta debe ser mayor al precio de compra');
            }
        } else {
            showModal('La cantidad, precio compra o precio venta no han sido lleados correctamente');
        }
    } else {
        showModal('Le faltan campos por llenar para poder agregar el producto');
    }
}

function limpiarCampos() {
    $('#producto_id').val('').trigger('change');
    $('#cantidad').val('');
    $('#precio_compra').val('');
    $('#precio_venta').val('');
}

function round(num, decimales = 2) {
    var signo = (num >= 0 ? 1 : -1);
    num = num * signo;
    if (decimales === 0)
        return signo * Math.round(num);
    // round(x * 10 ^ decimales)
    num = num.toString().split('e');
    num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
    // x * 10 ^ (-decimales)
    num = num.toString().split('e');
    return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
}

function showModal(message, icon = 'error') {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: icon,
        title: message
    });
}

function eliminarProducto(id) {
    const miFila = document.getElementById("fila" + id);
    const subTot = miFila.cells[4];
    total -= round(subTot.textContent);

    $('#total').html(total);
    $('#inputTotal').val(total);

    miFila.remove();

    disableButtons();
}

function existeProductoEnTabla(idProd) {
    var existe = false;

    $('#tabla tr').each(function() {
        var filaId = $(this).attr('id');
        if (filaId === 'fila' + idProd) {
            existe = true;
            return false;
        }
    });

    return existe;
}

function cancelarCompra() {
    $('#tabla > tbody').empty();
    total = 0;
    disableButtons();
    limpiarCampos();
    $('#total').html(total);
    $('#inputTotal').val(total);
}

function disableButtons() {
    if (total == 0) {
        $('#guardar').hide();
        $('#cancelar').hide();
    } else {
        $('#guardar').show();
        $('#cancelar').show();
    }
}
</script>
@endpush