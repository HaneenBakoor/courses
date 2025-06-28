<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CourseResource;
use App\Http\Requests\CourseUpdateRequest;

class CourseController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $courses = Course::all();
        return $this->successResponse(CourseResource::collection($courses));
    }


    public function store(CourseRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();
        $course = Course::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'finish_date' => $validated['finish_date'],
            'cost' => $validated['cost'],
            'teacher_id' => $user->id
        ]);

        return $this->successResponse(new CourseResource($course), "created successfully");
    }


    public function show(string $id)
    {
        $course = Course::findOrfail($id);
        return $this->successResponse(new CourseResource($course));
    }


    public function update(CourseUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $course = Course::findorfail($id);
        $course->update(
            $validated

        );
        return $this->successResponse("updated successfully");
    }


    public function destroy(string $id)
    {
        $course = Course::findorfail($id);
        $course->delete();
        return $this->successResponse("deleted successfully");
    }

   
}
