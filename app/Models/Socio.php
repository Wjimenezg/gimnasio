<?php
namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Socio extends Model {
    protected $fillable = ['codigo', 'nombre', 'telefono', 'email', 'activo'];
    public function membresias() { return $this->hasMany(Membresia::class); }
    public function asistencias() { return $this->hasMany(Asistencia::class); }
    /** Usar siempre con Socio::withMax('membresias','fin') */
    public function getVigenteAttribute(): bool {
        return $this->membresias_max_fin && Carbon::parse($this->membresias_max_fin)->gte(today());
    }
}
