<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCanShowRolePage(): void
    {
        $user = User::role('admin')->get()->random();
        $this->actingAs($user);
        $this->get('/roles')
        ->assertOk();
    }

    public function testCannotShowRolesPage(): void
    {
        $user = User::role('staff')->get()->random();
        $this->actingAs($user)
        ->get('roles')
        ->assertStatus(403);

    }

    public function testCannotShowRolesNotLogin(): void
    {
        $this->get('roles')
        ->assertRedirect('/login')
        ->assertStatus(302);
    }

    public function testCanCreateRole(): void
    {
        $user = User::role('admin')->get()->random();
        $this->actingAs($user);
        $this->get('/roles/create')
        ->assertOk();
    }

}
