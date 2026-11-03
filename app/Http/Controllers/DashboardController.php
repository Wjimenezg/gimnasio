<?php
namespace App\Http\Controllers;
use App\Models\{Asistencia, Membresia, Socio};

class DashboardController extends Controller {
    public function __invoke() {
        $vigente = fn ($q) => $q->whereDate('fin', '>=', today());
        return view('dashboard', [
            'total'    => Socio::count(),
            'activos'  => Socio::whereHas('membresias', $vigente)->count(),
            'hoy'      => Asistencia::whereDate('entrada', today())->count(),
            'ingresos' => Membresia::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->sum('monto'),
            // Solo socios cuya última membresía vence en 7 días (si ya renovó, no aparece).
            'porVencer'=> Socio::withMax('membresias', 'fin')
                ->whereHas('membresias', fn ($q) => $q->whereBetween('fin', [today(), today()->addDays(7)]))
                ->whereDoesntHave('membresias', fn ($q) => $q->whereDate('fin', '>', today()->addDays(7)))
                ->orderBy('membresias_max_fin')->get(),
        ]);
    }
}
