<?php
namespace App\Http\Controllers;
use App\Models\{Asistencia, Socio};
use Illuminate\Http\Request;

class AsistenciaController extends Controller {
    public function index() {
        return view('checkin', ['hoy' => Asistencia::with('socio')->whereDate('entrada', today())->latest('entrada')->get()]);
    }
    /** POST /api/asistencias -> JSON (usado por fetch en la vista de ingreso) */
    public function store(Request $r) {
        $r->validate(['codigo' => 'required|string|max:10']);
        $s = Socio::withMax('membresias', 'fin')->where('codigo', strtoupper(trim($r->codigo)))->first();
        if (!$s) return response()->json(['ok' => false, 'msg' => 'Código no encontrado.'], 404);
        if (!$s->activo || !$s->vigente) return response()->json(['ok' => false, 'msg' => "{$s->nombre}: membresía vencida. Debe renovar."], 422);
        Asistencia::create(['socio_id' => $s->id]);
        return response()->json(['ok' => true, 'msg' => "Bienvenido/a, {$s->nombre}", 'hora' => now()->format('H:i'), 'vence' => $s->membresias_max_fin]);
    }
}
