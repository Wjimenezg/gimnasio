<?php
namespace App\Http\Controllers;
use App\Models\{Plan, Socio};
use Carbon\Carbon;
use Illuminate\Http\Request;

class MembresiaController extends Controller {
    public function store(Request $r, Socio $socio) {
        $d = $r->validate(['plan_id' => 'required|exists:planes,id', 'metodo' => 'required|in:efectivo,tarjeta,transferencia']);
        $plan = Plan::findOrFail($d['plan_id']);
        $ultima = $socio->membresias()->max('fin');
        // Si aún tiene días vigentes, la renovación empieza al terminar la actual.
        $inicio = $ultima && $ultima >= today()->toDateString() ? Carbon::parse($ultima)->addDay() : today();
        $fin = $inicio->copy()->addDays($plan->dias - 1);
        $socio->membresias()->create(['plan_id' => $plan->id, 'inicio' => $inicio, 'fin' => $fin, 'monto' => $plan->precio, 'metodo' => $d['metodo']]);
        return back()->with('ok', "Pago de Q{$plan->precio} registrado. Plan {$plan->nombre} activo hasta {$fin->format('d/m/Y')}.");
    }
}
