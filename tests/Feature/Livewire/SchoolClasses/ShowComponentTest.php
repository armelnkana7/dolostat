<?php

namespace Tests\Feature\Livewire\SchoolClasses;

use App\Livewire\SchoolClasses\Show;
use App\Models\SchoolClass;
use App\Models\WeeklyCoverageReport;
use Livewire\Livewire;
use Tests\TestCase;

class ShowComponentTest extends TestCase
{
    /** @test */
    public function component_renders_successfully()
    {
        $class = SchoolClass::factory()->create();

        Livewire::test(Show::class, ['id' => $class->id])
            ->assertStatus(200);
    }

    /** @test */
    public function displays_class_information()
    {
        $class = SchoolClass::factory()->create(['name' => 'Terminale S1']);

        Livewire::test(Show::class, ['id' => $class->id])
            ->assertSee('Terminale S1');
    }

    /** @test */
    public function displays_coverage_statistics()
    {
        $class = SchoolClass::factory()->create();

        Livewire::test(Show::class, ['id' => $class->id])
            ->assertSee('Progression Globale')
            ->assertSee('Rapports Hebdomadaires');
    }

    /** @test */
    public function displays_weekly_reports()
    {
        $class = SchoolClass::factory()->create();
        $report = WeeklyCoverageReport::factory()
            ->create(['school_class_id' => $class->id]);

        Livewire::test(Show::class, ['id' => $class->id])
            ->assertSee('Semaine');
    }

    /** @test */
    public function displays_empty_state_when_no_reports()
    {
        $class = SchoolClass::factory()->create();

        Livewire::test(Show::class, ['id' => $class->id])
            ->assertSee('Aucun rapport de couverture');
    }

    /** @test */
    public function computes_coverage_metrics()
    {
        $class = SchoolClass::factory()->create();

        Livewire::test(Show::class, ['id' => $class->id])
            ->assertSee('Détails de couverture par métrique')
            ->assertSee('Heures')
            ->assertSee('Cours');
    }
}
