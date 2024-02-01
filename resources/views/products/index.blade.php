@extends('dashboard')

@section('section_dashboard')

<a class="btn btn-sm btn-secondary mb-2 mt-2" href="{{ route('productos.create') }}">Agregar Producto</a>

<div class="card text-white" >

    <div class="card-header bg-secondary">Productos</div>
    <div class="card-body">
        <table class="table table-striped table-sm text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Imagen1</th>
                    <th>Imagen2</th>
                    <th>Video</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>
                            <img src="media/images/{{ $producto->img1}}" width="70" height="70">
                        </td>
                        <td>
                            <img src="media/images/{{ $producto->img2}}" width="70" height="70">
                        </td>
                        <td>
                            <video  width="70" height="70">
                                <source src="media/videos/{{ $producto->video}}" type="video/mp4">
                            </video>
                        </td>

                        <td class="d-flex flex-row justify-content-center">
                            <a class="btn btn-sm btn-info"
                                href="{{ route('productos.show', $producto->id) }}">VER</a>&nbsp;
                            <a class="btn btn-sm btn-warning"
                                href="{{ route('productos.edit', $producto->id) }}">EDITAR</a>&nbsp;
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"> ELIMINAR</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
