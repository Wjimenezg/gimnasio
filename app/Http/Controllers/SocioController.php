<?php
namespace App\Http\Controllers;
use App\Models\{Plan, Socio};
use Illuminate\Http\Request;

class SocioController extends Controller {
    private function rules(): array {
        return ['nombre' => 'required|string|max:120', 'telefono' => ['required', 'regex:/^[0-9\- ]{8,20}$/'],
                'email' => 'nullable|email|max:120'];
    }
    public function index(Request $r) {
        $vigente = fn ($q) => $q->whereDate('fin', '>=', today());
        $socios = Socio::withMax('membresias', 'fin')
            ->when($r->q, fn ($q, $t) => $q->where(fn ($w) => $w->where('nombre', 'like', "%$t%")->orWhere('codigo', 'like', "%$t%")->orWhere('telefono', 'like', "%$t%")))
            ->when($r->estado === 'vigente', fn ($q) => $q->whereHas('membresias', $vigente))
            ->when($r->estado === 'vencido', fn ($q) => $q->whereDoesntHave('membresias', $vigente))
            ->orderBy('nombre')->paginate(10)->withQueryString();
        return view('socios.index', compact('socios'));
    }
    public function create() { return view('socios.form', ['socio' => new Socio]); }
    public function store(Request $r) {
        $d = $r->validate($this->rules());
        $d['codigo'] = 'G' . str_pad(Socio::max('id') + 1, 4, '0', STR_PAD_LEFT);
        $s = Socio::create($d);
        return redirect()->route('socios.show', $s)->with('ok', "Socio creado con código {$s->codigo}. Registra su primera membresía.");
    }
    public function show(Socio $socio) {
        $socio->loadMax('membresias', 'fin')->load(['membresias' => fn ($q) => $q->with('plan')->latest('fin'), 'asistencias' => fn ($q) => $q->latest('entrada')->limit(8)]);
        return view('socios.show', ['socio' => $socio, 'planes' => Plan::orderBy('precio')->get()]);
    }
    public function edit(Socio $socio) { return view('socios.form', compact('socio')); }
    public function update(Request $r, Socio $socio) {
        $socio->update($r->validate($this->rules()) + ['activo' => $r->boolean('activo')]);
        return redirect()->route('socios.show', $socio)->with('ok', 'Datos actualizados.');
    }
    public function destroy(Socio $socio) {
        $socio->delete();
        return redirect()->route('socios.index')->with('ok', 'Socio eliminado.');
    }
}
