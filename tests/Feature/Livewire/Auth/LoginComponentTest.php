<?php

namespace Tests\Feature\Livewire\Auth;

use App\Models\User;
use App\Models\Establishment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoginComponentTest extends TestCase
{
    use RefreshDatabase;

    protected Establishment $establishment;

    protected function setUp(): void
    {
        parent::setUp();
        $this->establishment = Establishment::factory()->create();
    }

    /**
     * Test login page renders correctly
     */
    public function test_login_page_renders()
    {
        $this->get('/saul/login')
            ->assertStatus(200)
            ->assertViewIs('auth.saul-login');
    }

    /**
     * Test login component is rendered
     */
    public function test_login_component_renders()
    {
        Livewire::test('auth.login')
            ->assertViewIs('livewire.auth.login');
    }

    /**
     * Test successful login with Livewire
     */
    public function test_can_login_with_livewire()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'establishment_id' => $this->establishment->id,
        ]);

        Livewire::test('auth.login')
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->call('login')
            ->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login fails with wrong password
     */
    public function test_login_fails_with_wrong_password()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('correctpassword'),
            'establishment_id' => $this->establishment->id,
        ]);

        Livewire::test('auth.login')
            ->set('email', 'test@example.com')
            ->set('password', 'wrongpassword')
            ->call('login')
            ->assertHasErrors('password');

        $this->assertGuest();
    }

    /**
     * Test login fails with non-existent user
     */
    public function test_login_fails_with_non_existent_user()
    {
        Livewire::test('auth.login')
            ->set('email', 'nonexistent@example.com')
            ->set('password', 'password123')
            ->call('login')
            ->assertHasErrors('email');

        $this->assertGuest();
    }

    /**
     * Test validation for required fields
     */
    public function test_email_is_required()
    {
        Livewire::test('auth.login')
            ->set('email', '')
            ->set('password', 'password123')
            ->call('login')
            ->assertHasErrors('email');
    }

    public function test_password_is_required()
    {
        Livewire::test('auth.login')
            ->set('email', 'test@example.com')
            ->set('password', '')
            ->call('login')
            ->assertHasErrors('password');
    }

    /**
     * Test remember me functionality
     */
    public function test_login_with_remember_me()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'establishment_id' => $this->establishment->id,
        ]);

        Livewire::test('auth.login')
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->set('rememberMe', true)
            ->call('login')
            ->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }
}
