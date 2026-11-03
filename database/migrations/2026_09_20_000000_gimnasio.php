<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', fn (Blueprint $t) => $t->string('role', 20)->default('recepcion'));
        Schema::create('planes', function (Blueprint $t) {
            $t->id(); $t->string('nombre'); $t->decimal('precio', 8, 2); $t->unsignedSmallInteger('dias'); $t->timestamps();
        });
        Schema::create('socios', function (Blueprint $t) {
            $t->id(); $t->string('codigo', 10)->unique(); $t->string('nombre'); $t->string('telefono', 20);
            $t->string('email')->nullable(); $t->boolean('activo')->default(true); $t->timestamps();
        });
        Schema::create('membresias', function (Blueprint $t) {
            $t->id(); $t->foreignId('socio_id')->constrained('socios')->cascadeOnDelete();
            $t->foreignId('plan_id')->constrained('planes');
            $t->date('inicio'); $t->date('fin')->index(); $t->decimal('monto', 8, 2); $t->string('metodo', 20); $t->timestamps();
        });
        Schema::create('asistencias', function (Blueprint $t) {
            $t->id(); $t->foreignId('socio_id')->constrained('socios')->cascadeOnDelete(); $t->timestamp('entrada')->useCurrent();
        });
    }
    public function down(): void {
        foreach (['asistencias', 'membresias', 'socios', 'planes'] as $tb) Schema::dropIfExists($tb);
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn('role'));
    }
};
