<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Establishment;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SchoolClassTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an authenticated admin can view the school classes index
     */
    public function test_admin_can_view_school_classes_index(): void
    {
        // Create establishment
        $establishment = Establishment::factory()->create([
            'code' => 'EST001',
            'name' => 'Test Establishment',
        ]);

        // Create admin user
        /** @var User $admin */
        $admin = User::factory()->create([
            'establishment_id' => $establishment->id,
            'email' => 'admin@test.com',
        ]);
        $admin->assignRole('admin');
        $department = Department::factory()->create([
            'establishment_id' => $establishment->id,
        ]);

        // Create school class
        $schoolClass = SchoolClass::factory()->create([
            'establishment_id' => $establishment->id,
            'department_id' => $department->id,
        ]);

        // Session setup
        session(['establishment_id' => $establishment->id]);

        // Test the view with Livewire
        $this->actingAs($admin)
            ->get('/classes')
            ->assertOk();
    }

    /**
     * Test that an admin can create a new school class
     */
    public function test_admin_can_create_school_class(): void
    {
        // Create establishment
        $establishment = Establishment::factory()->create([
            'code' => 'EST001',
            'name' => 'Test Establishment',
        ]);

        // Create department
        $department = Department::factory()->create([
            'establishment_id' => $establishment->id,
        ]);

        // Create admin user
        $admin = User::factory()->create([
            'establishment_id' => $establishment->id,
        ]);

        // Session setup
        session(['establishment_id' => $establishment->id]);

        // Test creating a school class through Livewire
        Livewire::actingAs($admin)
            ->test('school-classes.form')
            ->set('establishment_id', $establishment->id)
            ->set('department_id', $department->id)
            ->set('name', 'Test Class')
            ->set('level', '1st Year')
            ->call('save');

        // Verify the class was created
        $this->assertDatabaseHas('classes', [
            'name' => 'Test Class',
            'establishment_id' => $establishment->id,
            'department_id' => $department->id,
        ]);
    }

    /**
     * Test that school classes are scoped by establishment
     */
    public function test_school_classes_scoped_by_establishment(): void
    {
        // Create two establishments
        $est1 = Establishment::factory()->create(['code' => 'EST001']);
        $est2 = Establishment::factory()->create(['code' => 'EST002']);

        // Create departments
        $dept1 = Department::factory()->create(['establishment_id' => $est1->id]);
        $dept2 = Department::factory()->create(['establishment_id' => $est2->id]);

        // Create classes for each establishment
        $class1 = SchoolClass::factory()->create([
            'establishment_id' => $est1->id,
            'department_id' => $dept1->id,
        ]);

        $class2 = SchoolClass::factory()->create([
            'establishment_id' => $est2->id,
            'department_id' => $dept2->id,
        ]);

        // Create user for est1
        $user = User::factory()->create(['establishment_id' => $est1->id]);

        // Session setup
        session(['establishment_id' => $est1->id]);

        // Verify user can see their establishment's classes
        $query = SchoolClass::forEstablishment($est1->id);
        $this->assertTrue($query->where('id', $class1->id)->exists());
        $this->assertFalse($query->where('id', $class2->id)->exists());
    }
}
