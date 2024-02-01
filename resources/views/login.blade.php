@extends('app')

@if ($mensaje = Session::get('error'))
<div class="alert alert-danger py-2 mt-1 text-center"  id="msg">
    <strong>{{ $mensaje }}</strong>
</div>
@endif

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card text-white" style="max-width: 18rem;">
            <div class="card-header bg-secondary">Login</div>
            <div class="card-body">
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-black">Correo</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-black">Contraseña</label>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3 d-grid">
                        <button type="submit" class="btn btn-secondary btn-block">Iniciar sesion</button>
                    </div>
                </form>
                <div class="mb-3 d-grid">
                  <a href="{{ route('registraUsuario') }}">Resgistrate!</a>
                </div>
            </div>
        </div>
    </div>

@stop
@section('js')
<script>
    $(document).ready(function(){
        $("#msg").fadeOut(7500);
    });
</script>
@endsection
