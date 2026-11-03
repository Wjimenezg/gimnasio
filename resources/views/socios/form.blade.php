@extends('layout') @section('title', $socio->exists ? 'Editar socio' : 'Nuevo socio')
@section('content')
<div class="row"><div class="col-lg-6">
<h1 class="h3 mb-3">{{ $socio->exists ? 'Editar socio' : 'Nuevo socio' }}</h1>
<form method="POST" class="card border-0 shadow-sm card-body" action="{{ $socio->exists ? route('socios.update',$socio) : route('socios.store') }}" novalidate>
 @csrf @if($socio->exists) @method('PUT') @endif
 @foreach([['nombre','Nombre completo','text'],['telefono','Teléfono','tel'],['email','Correo (opcional)','email']] as [$n,$l,$t])
 <div class="mb-3"><label class="form-label" for="{{ $n }}">{{ $l }}</label>
  <input id="{{ $n }}" name="{{ $n }}" type="{{ $t }}" value="{{ old($n,$socio->$n) }}" class="form-control @error($n) is-invalid @enderror" @if($n!=='email') required @endif>
  @error($n)<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
 @endforeach
 @if($socio->exists)<div class="form-check form-switch mb-3"><input class="form-check-input" type="checkbox" name="activo" value="1" id="a" @checked(old('activo',$socio->activo))><label class="form-check-label" for="a">Socio activo</label></div>@endif
 <div class="d-flex gap-2"><button class="btn btn-primary">Guardar</button><a class="btn btn-light" href="{{ route('socios.index') }}">Cancelar</a></div>
</form></div></div>
@endsection
