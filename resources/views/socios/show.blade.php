@extends('layout') @section('title',$socio->nombre)
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
 <div><h1 class="h3 mb-1">{{ $socio->nombre }}</h1><div class="text-muted">Código {{ $socio->codigo }} · {{ $socio->telefono }}</div></div>
 <div class="d-flex gap-2">
  <a class="btn btn-outline-dark" href="{{ route('socios.edit',$socio) }}">Editar</a>
  @if(auth()->user()->role==='admin')
  <form method="POST" action="{{ route('socios.destroy',$socio) }}" onsubmit="return confirm('¿Eliminar a este socio y todo su historial?')">@csrf @method('DELETE')<button class="btn btn-outline-danger">Eliminar</button></form>@endif
 </div></div>
<div class="row g-3">
 <div class="col-lg-5"><div class="card border-0 shadow-sm"><div class="card-body">
  <h2 class="h6">Estado</h2>
  @if($socio->vigente)<span class="badge text-bg-success fs-6">Vigente hasta {{ \Carbon\Carbon::parse($socio->membresias_max_fin)->format('d/m/Y') }}</span>
  @else<span class="badge text-bg-danger fs-6">Sin membresía vigente</span>@endif
  <hr><h2 class="h6">Registrar pago / renovar</h2>
  <form method="POST" action="{{ route('membresias.store',$socio) }}">@csrf
   <select name="plan_id" class="form-select mb-2" required>@foreach($planes as $p)<option value="{{ $p->id }}">{{ $p->nombre }} · Q{{ number_format($p->precio,2) }} · {{ $p->dias }} días</option>@endforeach</select>
   <select name="metodo" class="form-select mb-2" required><option>efectivo</option><option>tarjeta</option><option>transferencia</option></select>
   <button class="btn btn-primary w-100">Cobrar y activar</button>
  </form></div></div></div>
 <div class="col-lg-7"><div class="card border-0 shadow-sm mb-3"><div class="card-header bg-white fw-semibold">Historial de pagos</div>
  <div class="table-responsive"><table class="table mb-0"><thead><tr><th>Plan</th><th>Periodo</th><th>Monto</th></tr></thead><tbody>
  @forelse($socio->membresias as $m)<tr><td>{{ $m->plan->nombre }}</td><td>{{ $m->inicio->format('d/m/y') }} – {{ $m->fin->format('d/m/y') }}</td><td>Q{{ number_format($m->monto,2) }} <small class="text-muted">{{ $m->metodo }}</small></td></tr>
  @empty<tr><td colspan="3" class="text-muted text-center py-3">Aún no hay pagos.</td></tr>@endforelse</tbody></table></div></div>
  <div class="card border-0 shadow-sm"><div class="card-header bg-white fw-semibold">Últimos ingresos</div><ul class="list-group list-group-flush">
   @forelse($socio->asistencias as $a)<li class="list-group-item">{{ $a->entrada->format('d/m/Y H:i') }}</li>@empty<li class="list-group-item text-muted">Sin ingresos todavía.</li>@endforelse</ul></div>
 </div></div>
@endsection
