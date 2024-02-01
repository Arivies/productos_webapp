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
            <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label text-black">Nombre</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nombre"
                        name="nombre" value="{{ old('nombre',$producto->nombre) }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label  class="col-sm-3 col-form-label text-black">Imagen 1</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control" id="img1" name="img1" accept="image/*">
                        <img src="/media/images/{{ $producto->img1}}" width="70" height="70">
                        <input type="hidden"  id="ant_img1" name="ant_img1" value="{{ $producto->img1}}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label  class="col-sm-3 col-form-label text-black">Imagen 2</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control" id="img2" name="img2" accept="image/*">
                        <img src="/media/images/{{ $producto->img2}}" width="70" height="70">
                        <input type="hidden" id="ant_img2" name="ant_img2" value="{{ $producto->img2}}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label  class="col-sm-3 col-form-label text-black">Video</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control" id="video" name="video" accept="video/*">
                        <video  width="70" height="70">
                            <source src="/media/videos/{{ $producto->video}}" type="video/mp4">
                        </video>
                        <input type="hidden" class="form-control" id="ant_video" name="ant_video" value="{{ $producto->video}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-md btn-secondary">Actualizar</button>
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
