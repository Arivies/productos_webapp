@extends('dashboard')

@section('section_dashboard')

@if ($mensaje = Session::get('error'))
<div class="alert alert-danger py-2 mt-1 text-center"  id="msg">
    <strong>{{ $mensaje }}</strong>
</div>
@endif

<div class="d-flex justify-content-center mt-2" >
    <div class="card text-white" >
        <div class="card-header bg-secondary">Agregar Producto</div>
        <div class="card-body">
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label text-black">Nombre</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nombre" name="nombre">
                    </div>
                </div>
                <div class="row mb-3">
                    <label  class="col-sm-3 col-form-label text-black">Imagen 1</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control" id="img1" name="img1" accept="image/*">
                    </div>
                </div>
                <div class="row mb-3">
                    <label  class="col-sm-3 col-form-label text-black">Imagen 2</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control" id="img2" name="img2" accept="image/*">
                    </div>
                </div>
                <div class="row mb-3">
                    <label  class="col-sm-3 col-form-label text-black">Video</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control" id="video" name="video" accept="video/*">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-md btn-secondary">Guardar</button>
                </div>
            </form>
            <a class="btn btn-secondary btn-sm" href="{{ route('productos.index') }}">REGRESAR</a>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $("#msg").fadeOut(7500);
    });
</script>
@endsection
