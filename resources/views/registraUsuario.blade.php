@extends('app')


@section('content')
    <div class="d-flex justify-content-center">
        <div class="card text-white" style="max-width: 18rem;">
            <div class="card-header bg-secondary">Resgistro de Usuarios</div>
            <div class="card-body">
                <form action="{{ route('registro') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-black">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-black">Correo</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-black">Contraseña</label>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3 d-grid">
                        <button type="submit" class="btn btn-secondary btn-block">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
