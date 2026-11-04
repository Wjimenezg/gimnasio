@extends('layout') @section('title','Planes')
@section('content')
<h1 class="h3 mb-3">Planes de membresía</h1>
<div class="row g-3"><div class="col-lg-4"><form method="POST" action="{{ route('planes.store') }}" class="card border-0 shadow-sm card-body">@csrf
 <h2 class="h6">Nuevo plan</h2>
 @foreach([['nombre','Nombre','text'],['precio','Precio (Q)','number'],['dias','Duración (días)','number']] as [$n,$l,$t])
 <div class="mb-2"><label class="form-label" for="{{ $n }}">{{ $l }}</label><input id="{{ $n }}" name="{{ $n }}" type="{{ $t }}" step="0.01" min="1" value="{{ old($n) }}" class="form-control @error($n) is-invalid @enderror" required>@error($n)<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
 @endforeach
 <button class="btn btn-primary mt-2">Crear plan</button></form></div>
 <div class="col-lg-8"><div class="card border-0 shadow-sm"><div class="table-responsive"><table class="table align-middle mb-0">
  <thead><tr><th>Plan</th><th>Precio</th><th>Días</th><th>Pagos</th><th></th></tr></thead><tbody>
  @foreach($planes as $p)<tr><td>{{ $p->nombre }}</td><td>Q{{ number_format($p->precio,2) }}</td><td>{{ $p->dias }}</td><td>{{ $p->membresias_count }}</td>
   <td class="text-end"><form method="POST" action="{{ route('planes.destroy',$p) }}" onsubmit="return confirm('¿Eliminar el plan?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Eliminar</button></form></td></tr>@endforeach
  </tbody></table></div></div></div></div>
@endsection
