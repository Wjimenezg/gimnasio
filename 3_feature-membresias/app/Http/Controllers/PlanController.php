<?php
namespace App\Http\Controllers;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller {
    public function index() { return view('planes.index', ['planes' => Plan::withCount('membresias')->orderBy('precio')->get()]); }
    public function store(Request $r) {
        Plan::create($r->validate(['nombre' => 'required|max:60', 'precio' => 'required|numeric|min:1|max:99999', 'dias' => 'required|integer|min:1|max:730']));
        return back()->with('ok', 'Plan creado.');
    }
    public function destroy(Plan $plan) {
        if ($plan->membresias()->exists()) return back()->with('error', 'Este plan ya tiene pagos registrados y no se puede eliminar.');
        $plan->delete();
        return back()->with('ok', 'Plan eliminado.');
    }
}
