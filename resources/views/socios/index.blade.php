@extends('layout') @section('title','Socios')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3 mb-0">Socios</h1>
 <a href="{{ route('socios.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nuevo socio</a></div>
<form class="row g-2 mb-3" method="GET">
 <div class="col-12 col-md-6"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar por nombre, código o teléfono"></div>
 <div class="col-6 col-md-3"><select name="estado" class="form-select">
  <option value="">Todos</option><option value="vigente" @selected(request('estado')==='vigente')>Vigentes</option><option value="vencido" @selected(request('estado')==='vencido')>Vencidos</option></select></div>
 <div class="col-6 col-md-3"><button class="btn btn-outline-dark w-100">Filtrar</button></div>
</form>
<div class="card border-0 shadow-sm"><div class="table-responsive"><table class="table table-hover align-middle mb-0">
 <thead><tr><th>Código</th><th>Nombre</th><th class="d-none d-md-table-cell">Teléfono</th><th>Estado</th><th></th></tr></thead><tbody>
 @forelse($socios as $s)
  <tr><td>{{ $s->codigo }}</td><td>{{ $s->nombre }}</td><td class="d-none d-md-table-cell">{{ $s->telefono }}</td>
   <td>@if($s->vigente)<span class="badge text-bg-success">Vigente hasta {{ \Carbon\Carbon::parse($s->membresias_max_fin)->format('d/m/Y') }}</span>@else<span class="badge text-bg-danger">Vencida</span>@endif</td>
   <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('socios.show',$s) }}">Ver</a></td></tr>
 @empty <tr><td colspan="5" class="text-center text-muted py-4">No hay socios con ese criterio.</td></tr>
 @endforelse</tbody></table></div></div>
<div class="mt-3">{{ $socios->links('pagination::bootstrap-5') }}</div>
@endsection
