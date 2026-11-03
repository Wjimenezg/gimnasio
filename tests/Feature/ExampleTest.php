<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Sin sesión, el panel redirige al login (RF1).
     */
    public function test_sin_sesion_redirige_al_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }
}
