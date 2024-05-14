@extends('template')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" />
@endpush

@section('navigation')
<h2 class="page-title ">Editar Producto</h2>
<div class="ms-auto text-end">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Editar Producto
            </li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('productos.update', ['producto'=>$producto]) }}" enctype="multipart/form-data" method="post">
        @method('PATCH')
        @csrf
        <div class="form-group row">
            <div class="row g-3">
                <div class="col-md-12">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="3" maxlength="250"
                        autocomplete="off" style="resize:none">{{old('descripcion', $producto->descripcion)}}</textarea>
                    @error('descripcion')
                    <small class="text-danger">{{'*'.$message}}</small>
                    <script>
                    const razon = document.getElementById("descripcion");
                    razon.classList.add("form-control");
                    razon.classList.add("is-invalid");
                    </script>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="codigo_producto" class="form-label">Código:</label>
                    <input type="text" name="codigo_producto" id="codigo_producto" class="form-control" maxlength="150"
                        autocomplete="off" value="{{old('codigo_producto', $producto->codigo_producto)}}">
                    @error('codigo_producto')
                    <small class="text-danger">{{'*'.$message}}</small>
                    <script>
                    const codigo = document.getElementById("codigo_producto");
                    codigo.classList.add("form-control");
                    codigo.classList.add("is-invalid");
                    </script>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="procedencia" class="form-label">Procedencia:</label>
                    <input type="text" name="procedencia" id="procedencia" class="form-control" maxlength="100"
                        autocomplete="off" value="{{old('procedencia', $producto->procedencia)}}">
                    @error('procedencia')
                    <small class="text-danger">{{'*'.$message}}</small>
                    <script>
                    const procedencia = document.getElementById("procedencia");
                    procedencia.classList.add("form-control");
                    procedencia.classList.add("is-invalid");
                    </script>
                    @enderror
                </div>
                <div class="col-md-6 mb-2">
                    <label for="marca_id" class="form-label">Marca:</label>
                    <select name="marca_id" id="marca_id" class="select2 form-select shadow-none"
                        style="width: 100%; height: 36px">
                        <option value=""></option>
                        @foreach($marcas as $item)
                        @if ($producto->marca_id == $item->id)
                        <option selected value="{{ $item->id }}" {{ old('marca_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nombre }}
                        </option>
                        @else
                        <option value="{{ $item->id }}" {{ old('marca_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nombre }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                    @error('marca_id')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-2">
                    <label for="categoria_id" class="form-label">Categoría:</label>
                    <select name="categoria_id" id="categoria_id"
                        class="js-example-placeholder-single js-states form-control" style="width: 100%; height: 36px">
                        <option value=""></option>
                        @foreach($categorias as $item)
                        @if ($producto->categoria_id == $item->id)
                        <option selected value="{{ $item->id }}"
                            {{ old('categoria_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nombre }}
                        </option>
                        @else
                        <option value="{{ $item->id }}" {{ old('categoria_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nombre }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                    @error('categoria_id')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="image_path" class="form-label">Imagen:</label>
                    </br>
                    <div class="btn-group" role="group">
                        <input type="file" name="image_path" id="image_path" class="form-control"
                            accept="image/png, image/jpeg, image/jpg">
                        <button type="button" class="btn btn-dark" id="eliminar_img" style="margin-left: 10px">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                    @if ($producto->image_path != null)
                    <img src="{{ asset('storage/productos/' . $producto->image_path) }}" id="preview_image"
                        class="img-fluid mt-2" style="margin-right: 10px" width="250" height="250">
                    @else
                    <img id="preview_image" class="img-fluid mt-2" style="display: none; margin-right: 10px" width="250"
                        height="250">
                    @endif
                    @error('image_path')
                    <small class="text-danger">{{'*'.$message}}</small>
                    <script>
                    const image = document.getElementById("image_path");
                    image.classList.add("form-control");
                    image.classList.add("is-invalid");
                    </script>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="codigo_barra" class="form-label">Código de Barra:</label>
                    <input type="text" name="codigo_barra" id="codigo_barra" class="form-control" autocomplete="off"
                        value="{{ old('codigo_barra', $producto->codigo_barra) }}" maxlength="10" readonly>

                    <div class="d-flex align-items-center mt-2">
                        <?php
                        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                        $barcodeImage = base64_encode($generator->getBarcode($producto->codigo_barra, $generator::TYPE_CODE_128));
                        ?>
                        <img src="data:image/png;base64,<?= $barcodeImage ?>" class="img-fluid"
                            style="margin-right: 10px">
                        <button type="button" class="btn btn-secondary" onclick="showPrintView()">Imprimir</button>
                    </div>

                    @error('codigo_barra')
                    <small class="text-danger">{{'*'.$message}}</small>
                    <script>
                    const doc = document.getElementById("codigo_barra");
                    doc.classList.add("form-control", "is-invalid");
                    </script>
                    @enderror
                </div>
                <div>
                    <div class="border-top">
                        <button type="submit" class="btn btn-outline-success mt-3">
                            Actualizar
                        </button>
                        <button type="reset" class="btn btn-outline-secondary mt-3" id="restaurar">
                            Restaurar
                        </button>
                        <a href="{{ route('productos.index') }}"><button type="button"
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

@section('impresion')
<div id="printView" class="d-print-block" style="display:none">
    <div class="row">
        <div class="col">
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
            <figure class="figure border border-5 p-2">
                <img src="data:image/png;base64,<?= $barcodeImage ?>" class="figure-img img-fluid" alt="Barcode">
                <figcaption class="figure-caption text-primary text-center" style="font-size: 17px;">
                    {{ $producto->codigo_barra }}
                </figcaption>
            </figure>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>

<script>
$(document).ready(function() {
    $("#marca_id").select2({
        language: {
            noResults: function() {
                return "No hay resultado";
            },
            searching: function() {
                return "Buscando...";
            }
        },
        placeholder: 'Seleccione una marca',
        theme: "classic",
        allowClear: true
    });

    $("#categoria_id").select2({
        placeholder: 'Seleccione una categoría',
        theme: "classic",
        allowClear: true,
        language: {
            noResults: function() {
                return "No hay resultado";
            },
            searching: function() {
                return "Buscando...";
            }
        },
    });

    const li = document.getElementById("producto-li");
    li.classList.add("sidebar-item");
    li.classList.add("selected");
    const a = document.getElementById("producto-a");
    a.classList.add("sidebar-link");
    a.classList.add("waves-effect");
    a.classList.add("waves-dark");
    a.classList.add("active");

    $("#descripcion").on("keypress", function() {
        var $input = $(this);
        setTimeout(function() {
            $input.val($input.val().toUpperCase());
        }, 50);
    });

    $("#codigo_producto").on("keypress", function() {
        var $input = $(this);
        setTimeout(function() {
            $input.val($input.val().toUpperCase());
        }, 50);
    });

    $("#procedencia").on("keypress", function() {
        var $input = $(this);
        setTimeout(function() {
            $input.val($input.val().toUpperCase());
        }, 50);
    });

    const imageInput = document.getElementById("image_path");
    const originalImageUrl = "{{ asset('storage/productos/' . $producto->image_path) }}";

    const eliminarButton = document.getElementById("eliminar_img");
    const previewImage = document.getElementById("preview_image");

    const restaurarBtn = document.getElementById("restaurar");

    if ("{{ $producto->image_path }}" === "") {
        imageInput.addEventListener("change", () => {
            const file = imageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    previewImage.src = event.target.result;
                    previewImage.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        });

        eliminarButton.addEventListener("click", () => {
            previewImage.src = "";
            imageInput.value = "";
            previewImage.style.display = "none";
        });

        // Evento de clic en el botón "Restaurar"
        restaurarBtn.addEventListener("click", () => {
            previewImage.src = "";
            imageInput.value = "";
            previewImage.style.display = "none";
        });
    } else {
        imageInput.addEventListener("change", (event) => {
            const selectedFile = event.target.files[0];
            if (selectedFile) {
                const imageUrl = URL.createObjectURL(selectedFile);
                previewImage.src = imageUrl;
            }
        });

        eliminarButton.addEventListener("click", () => {
            previewImage.src = originalImageUrl;
            imageInput.value = "";
        });

        // Evento de clic en el botón "Restaurar"
        restaurarBtn.addEventListener("click", () => {
            previewImage.src = originalImageUrl;
            imageInput.value = "";
        });
    }
});

function showPrintView() {
    document.getElementById("printView").style.display = 'block';
    window.print();
    document.getElementById("printView").style.display = 'none';
}
</script>
@endpush