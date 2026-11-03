<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model {
    public $timestamps = false;
    protected $fillable = ['socio_id', 'entrada'];
    protected $casts = ['entrada' => 'datetime'];
    public function socio() { return $this->belongsTo(Socio::class); }
}
