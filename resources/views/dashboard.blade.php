@extends('app')

@section('nav')
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('dashboard') }}">Home</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('productos.index') }}">Productos</a>
          </li>
         <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('listaUsuarios') }}">Usuarios</a>
          </li>
         <li class="nav-item"> </li>
        </ul>
        <span class="text-white">Hola {{ Session::get('usuario') }}</span>
        <a class="nav-link text-white" aria-current="page" href="{{ route('logout') }}">Logout</a>
      </div>
    </div>
</nav>

<div class="container">
    @yield('section_dashboard')
</div>

@stop
