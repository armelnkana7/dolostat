<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Establishment;
use App\Models\Program;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First, seed permissions and roles
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
        ]);

        // Get the default establishment created by UserSeeder
        $establishment = Establishment::where('code', 'EST001')->first();
        if (!$establishment) {
            $establishment = Establishment::factory()->create([
                'code' => 'EST001',
                'name' => 'Établissement Principal',
            ]);
        }

        // Get or create academic year
        $academicYear = AcademicYear::where('establishment_id', $establishment->id)
            ->where('title', '2024-2025')
            ->first();

        if (!$academicYear) {
            $academicYear = AcademicYear::create([
                'establishment_id' => $establishment->id,
                'title' => '2024-2025',
                'start_date' => '2024-09-01',
                'end_date' => '2025-06-30',
                'is_active' => true,
            ]);
        }

        // Create departments
        $departments = [
            [
                'name' => 'Sciences & Technologie',
                'description' => 'Département des Sciences et Technologie',
                'classes' => ['1ère année', '2ème année', '3ème année', '4ème année']
            ],
            [
                'name' => 'Lettres & Humanités',
                'description' => 'Département des Lettres et Humanités',
                'classes' => ['1ère année', '2ème année', '3ème année']
            ],
            [
                'name' => 'Commerce & Gestion',
                'description' => 'Département du Commerce et Gestion',
                'classes' => ['1ère A ALL', '1ère A 4', '2ème A ALL', '2ème A 4', '3ème ESP']
            ],
        ];

        foreach ($departments as $deptData) {
            $department = Department::firstOrCreate(
                [
                    'establishment_id' => $establishment->id,
                    'name' => $deptData['name']
                ],
                ['description' => $deptData['description']]
            );

            // Create subjects for this department
            $subjects = $this->createSubjectsForDepartment($establishment->id, $department->id, $deptData['name']);

            // Create school classes for this department
            foreach ($deptData['classes'] as $className) {
                $class = SchoolClass::firstOrCreate(
                    [
                        'establishment_id' => $establishment->id,
                        'name' => $className
                    ],
                    [
                        'level' => $className,
                        'description' => "Classe de {$className}"
                    ]
                );

                // Create programs for each subject in this class
                foreach ($subjects as $subject) {
                    Program::firstOrCreate(
                        [
                            'establishment_id' => $establishment->id,
                            'classe_id' => $class->id,
                            'subject_id' => $subject->id,
                            'academic_year_id' => $academicYear->id,
                        ],
                        [
                            'nbr_hours' => rand(30, 60),
                            'type_cours' => $this->getRandomCourseType(),
                        ]
                    );
                }
            }
        }

        // Run additional seeders
        $this->call([
            WeeklyCoverageReportSeeder::class,
        ]);

        $this->command->info('Database seeded successfully!');
    }

    /**
     * Create subjects for a specific department
     */
    private function createSubjectsForDepartment($establishmentId, $departmentId, $departmentName)
    {
        $subjects = [];

        if (strpos($departmentName, 'Sciences') !== false) {
            $subjectNames = ['Mathématiques', 'Physique', 'Chimie', 'Biologie', 'Informatique'];
        } elseif (strpos($departmentName, 'Lettres') !== false) {
            $subjectNames = ['Français', 'Anglais', 'Histoire', 'Géographie', 'Philosophie'];
        } else {
            $subjectNames = ['Comptabilité', 'Économie', 'Gestion', 'Anglais', 'Informatique'];
        }

        foreach ($subjectNames as $index => $name) {
            $subject = Subject::firstOrCreate(
                [
                    'establishment_id' => $establishmentId,
                    'department_id' => $departmentId,
                    'name' => $name
                ],
                [
                    'code' => substr($name, 0, 3) . ($index + 1),
                    'description' => "Cours de {$name}"
                ]
            );
            $subjects[] = $subject;
        }

        return $subjects;
    }

    /**
     * Get a random course type
     */
    private function getRandomCourseType()
    {
        $types = ['lesson', 'lesson_dig', 'tp', 'tp_dig'];
        return $types[array_rand($types)];
    }
}
