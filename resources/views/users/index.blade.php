@extends('dashboard')

@section('section_dashboard')

<div class="card text-white" >

    <div class="card-header bg-secondary">Usuarios</div>
    <div class="card-body">
        <table class="table table-striped table-sm text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario['id'] }}</td>
                        <td>{{ $usuario['name'] }}</td>
                        <td>{{ $usuario['email'] }}</td>
                        <td class="d-flex flex-row justify-content-center">
                            <a class="btn btn-sm btn-info"
                                href="{{ url('muestraUsuario',['id'=> $usuario['id'] ]) }}" >VER</a>&nbsp;
                            <a class="btn btn-sm btn-warning"
                                href="{{ url('editaUsuario',['id' => $usuario['id'] ]) }}">EDITAR</a>&nbsp;
                            <form action="{{ url('eliminarUsuario',['id' => $usuario['id'] ]) }}" method="POST">
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
