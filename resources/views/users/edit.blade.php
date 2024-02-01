@extends('dashboard')

@section('section_dashboard')

    <div class="d-flex justify-content-center">
        <div class="card text-white" style="max-width: 18rem;">
            <div class="card-header bg-secondary">Editar de Usuario</div>
            <div class="card-body">
                <form action="{{ route('actualizaUsuario') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label text-black">Nombre</label>
                        <input type="hidden"  id="id" name="id" value="{{ $usuario['id'] }}">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $usuario['name'] }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-black">Correo</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $usuario['email'] }}">
                    </div>
                   <div class="mb-3">
                        <label class="form-label text-black">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" >
                        <input type="hidden"  id="ant_password" name="ant_password"  value="{{ $usuario['password'] }}" >

                    </div>
                    <div class="mb-3 d-grid">
                        <button type="submit" class="btn btn-secondary btn-block">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
