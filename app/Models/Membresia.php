<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model {
    protected $fillable = ['socio_id', 'plan_id', 'inicio', 'fin', 'monto', 'metodo'];
    protected $casts = ['inicio' => 'date', 'fin' => 'date'];
    public function socio() { return $this->belongsTo(Socio::class); }
    public function plan() { return $this->belongsTo(Plan::class); }
}
