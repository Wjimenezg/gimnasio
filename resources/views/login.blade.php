<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Iniciar sesión · IronPulse</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>body{background:#14213d}.btn-primary{background:#e4572e;border-color:#e4572e}</style></head>
<body class="d-flex align-items-center min-vh-100">
<div class="container" style="max-width:420px">
 <div class="card shadow border-0"><div class="card-body p-4">
  <h1 class="h4 fw-bold mb-1">IronPulse Gym</h1><p class="text-muted">Ingresa para gestionar el gimnasio.</p>
  <form method="POST" action="{{ route('login') }}">@csrf
   <div class="mb-3"><label class="form-label" for="email">Correo</label>
    <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
   <div class="mb-3"><label class="form-label" for="password">Contraseña</label><input id="password" name="password" type="password" class="form-control" required></div>
   <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" id="r"><label class="form-check-label" for="r">Mantener sesión</label></div>
   <button class="btn btn-primary w-100">Iniciar sesión</button>
  </form>
 </div></div>
</div></body></html>
