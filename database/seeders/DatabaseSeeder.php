<?php
namespace Database\Seeders;
use App\Models\{Membresia, Plan, Socio, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::forceCreate(['name' => 'Administrador', 'email' => 'admin@gym.test', 'password' => Hash::make('password'), 'role' => 'admin']);
        User::forceCreate(['name' => 'Recepción', 'email' => 'recepcion@gym.test', 'password' => Hash::make('password'), 'role' => 'recepcion']);
        $planes = collect([['Mensual', 250, 30], ['Trimestral', 650, 90], ['Anual', 2200, 365]])
            ->map(fn ($p) => Plan::create(['nombre' => $p[0], 'precio' => $p[1], 'dias' => $p[2]]));
        foreach (range(1, 25) as $i) {
            $s = Socio::create(['codigo' => 'G' . str_pad($i, 4, '0', STR_PAD_LEFT), 'nombre' => fake()->name(), 'telefono' => fake()->numerify('####-####')]);
            $p = $planes->random(); $ini = now()->subDays(rand(0, 100));
            Membresia::create(['socio_id' => $s->id, 'plan_id' => $p->id, 'inicio' => $ini, 'fin' => $ini->copy()->addDays($p->dias - 1),
                'monto' => $p->precio, 'metodo' => 'efectivo']);
        }
    }
}
