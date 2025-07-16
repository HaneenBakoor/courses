<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $this->call([
            CourseSeeder::class,
        ]);

        User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make(123456789)
        ]);
        // $teachers = User::where('role', 'teacher')->get();

        // foreach ($teachers as $te) {
        //     Course::create([
        //         'title' => fake()->sentence(3),
        //         'description' => fake()->paragraph(),
        //         'start_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
        //         'finish_date' => fake()->dateTimeBetween('+1 month', '+3 months')->format('Y-m-d'),
        //         'cost' => fake()->randomFloat(2, 50, 500),
        //         'teacher_id' => $te->id,
        //     ]);
        // }


        $students = User::where('role', 'student')->get();
        $courses = Course::all();

        foreach ($courses as $co) {
            foreach ($students as $st) {
                $co->students()->attach($st->id, ['status' => fake()->randomElement(['passed', 'not_passed'])]);
            }
        }
    }
}
