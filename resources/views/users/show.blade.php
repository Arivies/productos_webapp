@extends('dashboard')

@section('section_dashboard')

<div class="container-sm w-75">
    <div class="card mt-5">
        <div class="card-header bg-secondary text-white">DETALLE DEL USUARIO</div>
        <div class="card-body">
            <div class="d-flex">
                <table class="table">
                    <tr>
                        <td>ID:</td>
                        <td class="text-center">{{ $usuario['id'] }}</td>
                    </tr>
                    <tr>
                        <td>NOMBRE:</td>
                        <td class="text-center">{{ $usuario['name'] }}</td>
                    </tr>
                    <tr>
                        <td>CORREO:</td>
                        <td class="text-center">{{ $usuario['email'] }}</td>
                    </tr>
                </table>
            </div>
            <a class="btn btn-secondary btn-sm" href="{{ route('listaUsuarios') }}">REGRESAR</a>
        </div>
    </div>
</div>

@endsection
