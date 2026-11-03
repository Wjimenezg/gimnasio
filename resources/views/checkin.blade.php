@extends('layout') @section('title','Ingreso')
@section('content')
<div class="row justify-content-center"><div class="col-md-7 col-lg-5">
 <div class="card border-0 shadow-sm mb-4"><div class="card-body p-4">
  <h1 class="h4">Registrar ingreso</h1><p class="text-muted">Escribe o escanea el código del socio.</p>
  <form id="f" class="input-group input-group-lg">
   <input id="codigo" class="form-control text-uppercase" maxlength="10" placeholder="G0001" required autofocus autocomplete="off">
   <button class="btn btn-primary">Entrar</button>
  </form>
  <div id="res" class="alert mt-3 d-none" role="status"></div>
 </div></div>
 <h2 class="h6 text-muted">Ingresos de hoy</h2>
 <ul id="lista" class="list-group">
  @foreach($hoy as $a)<li class="list-group-item">{{ $a->socio->nombre }} · {{ $a->entrada->format('H:i') }}</li>@endforeach
 </ul>
</div></div>
@endsection
@push('scripts')
<script>
const f = document.getElementById('f'), i = document.getElementById('codigo'), r = document.getElementById('res'), lista = document.getElementById('lista');
f.addEventListener('submit', async e => {
  e.preventDefault();
  try {
    const res = await fetch('{{ route('api.asistencias') }}', {
      method: 'POST',
      headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
      body: JSON.stringify({codigo: i.value})
    });
    const d = await res.json();
    r.className = 'alert mt-3 alert-' + (d.ok ? 'success' : 'danger');
    r.textContent = d.msg || Object.values(d.errors || {})[0]?.[0] || 'Error inesperado.';
    if (d.ok) { const li = document.createElement('li'); li.className = 'list-group-item'; li.textContent = d.msg.replace('Bienvenido/a, ', '') + ' · ' + d.hora; lista.prepend(li); }
  } catch { r.className = 'alert mt-3 alert-danger'; r.textContent = 'Sin conexión con el servidor.'; }
  i.value = ''; i.focus();
});
</script>
@endpush
