<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Cria o administrador
        User::create([
            'name'     => 'Joelson Pedo Mutute',
            'email'    => 'joelsonmututedev@gmail.com',
            'password' => Hash::make('olamundo123'),
            'role'     => 'admin',
            'status'   => 'active',
        ]);

        // Cria 10 cursos
        $courses = Course::factory(10)->create();

        // Cria 10 turmas
        $classes = SchoolClass::factory(10)->create();

        // Cria 10 disciplinas
        $subjects = Subject::factory(10)->create();

        // Cria 10 professores
        $teachers = Teacher::factory(10)->create();

        // Cria 10 alunos
        $students = Student::factory(10)->create();

        // Cria 10 matrículas
        $enrollments = Enrollment::factory(10)->create();

        // Cria 10 notas
        $grades = Grade::factory(10)->create();
    }
}
