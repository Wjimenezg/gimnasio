@extends('layout') @section('title','Inicio')
@section('content')
<h1 class="h3 mb-4">Resumen de hoy</h1>
<div class="row g-3 mb-4">
 @foreach([['Socios registrados',$total],['Membresías vigentes',$activos],['Ingresos hoy',$hoy],['Cobrado este mes','Q'.number_format($ingresos,2)]] as [$l,$v])
 <div class="col-6 col-lg-3"><div class="card stat border-0 shadow-sm"><div class="card-body"><div class="text-muted small">{{ $l }}</div><div class="n">{{ $v }}</div></div></div></div>
 @endforeach
</div>
<div class="card border-0 shadow-sm"><div class="card-header bg-white fw-semibold">Membresías que vencen en 7 días</div>
 <div class="table-responsive"><table class="table table-hover align-middle mb-0">
  <thead><tr><th>Socio</th><th>Teléfono</th><th>Vence</th><th></th></tr></thead><tbody>
  @forelse($porVencer as $s)
   <tr><td>{{ $s->nombre }}</td><td>{{ $s->telefono }}</td><td>{{ \Carbon\Carbon::parse($s->membresias_max_fin)->format('d/m/Y') }}</td>
   <td class="text-end"><a class="btn btn-sm btn-primary" href="{{ route('socios.show',$s) }}">Renovar</a></td></tr>
  @empty <tr><td colspan="4" class="text-center text-muted py-4">Nadie vence esta semana.</td></tr>
  @endforelse</tbody></table></div></div>
@endsection
