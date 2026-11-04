<?php
namespace Tests\Feature;
use App\Models\{Membresia, Plan, Socio, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckinTest extends TestCase {
    use RefreshDatabase;

    private function user(string $role = 'recepcion') {
        return User::forceCreate(['name' => 'T', 'email' => "$role@t.test", 'password' => bcrypt('x'), 'role' => $role]);
    }
    private function socio(int $diasFin) {
        $p = Plan::create(['nombre' => 'Mensual', 'precio' => 250, 'dias' => 30]);
        $s = Socio::create(['codigo' => 'G0001', 'nombre' => 'Ana', 'telefono' => '5555-5555']);
        Membresia::create(['socio_id' => $s->id, 'plan_id' => $p->id, 'inicio' => today()->subDays(30), 'fin' => today()->addDays($diasFin), 'monto' => 250, 'metodo' => 'efectivo']);
        return $s;
    }
    public function test_requiere_login() {
        $this->postJson('/api/asistencias', ['codigo' => 'G0001'])->assertUnauthorized();
    }
    public function test_socio_vigente_entra() {
        $this->socio(5);
        $this->actingAs($this->user())->postJson('/api/asistencias', ['codigo' => 'g0001'])->assertOk()->assertJson(['ok' => true]);
        $this->assertDatabaseCount('asistencias', 1);
    }
    public function test_socio_vencido_es_rechazado() {
        $this->socio(-1);
        $this->actingAs($this->user())->postJson('/api/asistencias', ['codigo' => 'G0001'])->assertStatus(422);
        $this->assertDatabaseCount('asistencias', 0);
    }
    public function test_recepcion_no_administra_planes() {
        $this->actingAs($this->user())->get('/planes')->assertForbidden();
        $this->actingAs($this->user('admin'))->get('/planes')->assertOk();
    }
}
