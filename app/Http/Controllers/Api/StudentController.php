<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CourseResource;

class StudentController extends Controller
{
    use ApiResponseTrait;

    //    get all students for admin
    public function index()
    {
        $users = User::where('role', 'student')->get();
        return $this->successResponse($users);
    }

    //get my courses

    public function getMyCourses()
    {
        $user = Auth::user();
        $courses = $user->enrolledCourses()->get();
        return $this->successResponse(CourseResource::collection($courses));
    }

    public function enrollCourse($course_id)
    {
        $user = Auth::user();

        if ($user->enrolledCourses()->where('course_id', $course_id)->exists()) {
            return $this->errorResponse("You have already been enrolled");
        }

        $user->enrolledCourses()->attach($course_id, ['status' => 'not_passed']);

        return $this->successResponse("Enrolled Successfully");
    }
}
