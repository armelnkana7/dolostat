<?php

namespace Tests\Feature\Livewire\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterComponentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test register page renders correctly
     */
    public function test_register_page_renders()
    {
        $this->get('/saul/register')
            ->assertStatus(200)
            ->assertViewIs('auth.saul-register');
    }

    /**
     * Test register component is rendered
     */
    public function test_register_component_renders()
    {
        Livewire::test('auth.register')
            ->assertViewIs('livewire.auth.register');
    }

    /**
     * Test successful registration with Livewire
     */
    public function test_can_register_with_livewire()
    {
        Livewire::test('auth.register')
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register')
            ->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
        ]);

        $this->assertAuthenticatedAs(User::where('email', 'john@example.com')->first());
    }

    /**
     * Test registration fails with existing email
     */
    public function test_register_fails_with_existing_email()
    {
        User::factory()->create(['email' => 'existing@example.com']);

        Livewire::test('auth.register')
            ->set('name', 'John Doe')
            ->set('email', 'existing@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register')
            ->assertHasErrors('email');
    }

    /**
     * Test registration fails with password mismatch
     */
    public function test_register_fails_with_password_mismatch()
    {
        Livewire::test('auth.register')
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password456')
            ->call('register')
            ->assertHasErrors('password');
    }

    /**
     * Test validation for required fields
     */
    public function test_name_is_required()
    {
        Livewire::test('auth.register')
            ->set('name', '')
            ->set('email', 'john@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register')
            ->assertHasErrors('name');
    }

    public function test_email_is_required()
    {
        Livewire::test('auth.register')
            ->set('name', 'John Doe')
            ->set('email', '')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register')
            ->assertHasErrors('email');
    }

    public function test_password_minimum_length()
    {
        Livewire::test('auth.register')
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('password', 'short')
            ->set('password_confirmation', 'short')
            ->call('register')
            ->assertHasErrors('password');
    }

    /**
     * Test invalid email format
     */
    public function test_email_must_be_valid()
    {
        Livewire::test('auth.register')
            ->set('name', 'John Doe')
            ->set('email', 'not-an-email')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register')
            ->assertHasErrors('email');
    }
}
