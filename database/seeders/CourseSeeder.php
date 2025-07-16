<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{

    public function run(): void
    {

    //     $courses = json_decode(file_get_contents(database_path('data/courses.json')), true);
    //     $teachers = json_decode(file_get_contents(database_path('data/teacher.json')), true);
    //     foreach ($teachers as $teacher) {
    //         User::create($teacher);
    //     }
    //     $teachers = User::where('role', 'teacher')->get();
    //     foreach ($courses as $course) {
    //         foreach ($teachers as $teacher) {
    //             Course::create([
    //                 'title' => $course['title'],
    //                 'description' => $course['description'],
    //                 'start_date' => $course['start_date'],
    //                 'finish_date' => $course['finish_date'],
    //                 'cost' => $course['cost'],
    //                 'level' => $course['level'],
    //                 'teacher_id' => $teacher['id']
    //             ]);
    //         }
    //     }
    // }


    $courses = json_decode(file_get_contents(database_path('data/courses.json')), true);
$teachers = json_decode(file_get_contents(database_path('data/teacher.json')), true);

// Seed the teachers first
foreach ($teachers as $teacher) {
    User::updateOrCreate(['email' => $teacher['email']], $teacher + [
        'password' => bcrypt($teacher['password']) // Optional: ensure it's hashed
    ]);
}

// Get all inserted teacher IDs
$teacherIds = User::where('role', 'teacher')->pluck('id')->toArray();

// Seed the courses
foreach ($courses as $course) {
    Course::create([
        'title' => $course['title'],
        'description' => $course['description'],
        'start_date' => $course['start_date'],
        'finish_date' => $course['finish_date'],
        'cost' => $course['cost'],
        'level' => $course['level'],
        'teacher_id' => $teacherIds[array_rand($teacherIds)]
    ]);
}

}
}
