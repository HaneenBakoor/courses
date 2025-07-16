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
            'level' => $validated['level'],
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
        $user = Auth::user();
        if ($user->id == $course->teacher_id) {
            $course->update(
                $validated

            );
            return $this->successResponse("updated successfully");
        }
        return  $this->unauthorized("you don't have permission to update this course");
    }


    public function destroy(string $id)
    {
        $course = Course::findorfail($id);
        $course->delete();
        return $this->successResponse("deleted successfully");
    }

    public function restore(string $id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        $course->restore();
        return $this->successResponse("restored successfully");
    }

    //    public function search(Request $request)
    // {
    //     $query = strtolower(trim($request->input('query')));
    //     $level = $request->input('level');

    //     $courses = Course::query()
    //         ->whereRaw('LOWER(title) LIKE ?', ['%' . $query . '%'])
    //         ->when($level, fn($q) => $q->where('level', $level))
    //         ->get();

    //     return $this->successResponse(CourseResource::collection($courses));
    // }
    public function search(Request $request)
    {
        $query = $request->input('query');

        $courses = Course::where('title', 'LIKE', "%{$query}%")->get();


        return $this->successResponse(CourseResource::collection($courses));
    }



    public function courses(Request $request)
    {
        $sortDirection = $request->input('sort_direction');
        $sortBy = $request->input('sort_by', 'created_at'); 

        $courses = Course::orderBy($sortBy, $sortDirection)->get();

        return $this->successResponse(CourseResource::collection($courses));
    }
}
