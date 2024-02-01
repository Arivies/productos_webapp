@extends('dashboard')

@section('section_dashboard')

<div class="container-sm w-75">
    <div class="card mt-5">
        <div class="card-header bg-secondary text-white">DETALLE DEL PRODUCTO</div>
        <div class="card-body">
            <div class="d-flex">
                <table class="table">
                    <tr>
                        <td>ID:</td>
                        <td class="text-center">{{ $producto->id }}</td>
                    </tr>
                    <tr>
                        <td>NOMBRE:</td>
                        <td class="text-center">{{ $producto->nombre }}</td>
                    </tr>
                    <tr>
                        <td>IMAGEN 1:</td>
                        <td class="text-center">
                            <img src="/media/images/{{ $producto->img1 }}" width="150" height="150">
                        </td>
                    </tr>
                    <tr>
                        <td>IMAGEN 2:</td>
                        <td class="text-center">
                            <img src="/media/images/{{ $producto->img2 }}" width="150" height="150">
                        </td>
                    </tr>
                    <tr>
                        <td>VIDEO:</td>
                        <td class="text-center">
                            <video  width="250" height="250" controls >
                                <source src="/media/videos/{{ $producto->video }}" type="video/mp4">
                            </video>
                        </td>
                    </tr>
                </table>
            </div>
            <a class="btn btn-secondary btn-sm" href="{{ route('productos.index') }}">REGRESAR</a>
        </div>
    </div>
</div>

@endsection
