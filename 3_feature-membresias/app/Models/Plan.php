<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model {
    protected $table = 'planes';
    protected $fillable = ['nombre', 'precio', 'dias'];
    public function membresias() { return $this->hasMany(Membresia::class); }
}
