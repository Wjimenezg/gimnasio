<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Panel') · IronPulse Gym</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root{--bs-primary:#e4572e;--bs-primary-rgb:228,87,46;--ink:#14213d}
body{background:#f4f5f7}
.navbar{background:var(--ink)}
.btn-primary{--bs-btn-bg:#e4572e;--bs-btn-border-color:#e4572e;--bs-btn-hover-bg:#c94622;--bs-btn-hover-border-color:#c94622;--bs-btn-active-bg:#b03d1e}
.stat{border-left:4px solid var(--bs-primary)}
.stat .n{font-size:2rem;font-weight:700;color:var(--ink)}
a{color:var(--ink)}
</style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark mb-4">
 <div class="container">
  <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}"><i class="bi bi-lightning-charge-fill text-primary"></i> IronPulse</a>
  <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#m"><span class="navbar-toggler-icon"></span></button>
  <div id="m" class="collapse navbar-collapse">
   <ul class="navbar-nav me-auto">
    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Inicio</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('socios.index') }}">Socios</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('checkin') }}">Ingreso</a></li>
    @if(auth()->user()->role === 'admin')<li class="nav-item"><a class="nav-link" href="{{ route('planes.index') }}">Planes</a></li>@endif
   </ul>
   <form method="POST" action="{{ route('logout') }}" class="d-flex align-items-center gap-2">@csrf
    <span class="text-white-50 small">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
    <button class="btn btn-outline-light btn-sm">Cerrar sesión</button>
   </form>
  </div>
 </div>
</nav>
<main class="container pb-5">
 @if(session('ok'))<div class="alert alert-success">{{ session('ok') }}</div>@endif
 @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
 @yield('content')
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body></html>
