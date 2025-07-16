<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;

class UserController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $users = User::whereIn('role', ['student', 'teacher'])->get();
        return $this->successResponse($users);
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {

        try {
            $user = User::findorfail($id);
            if ($user->role == 'admin') {
                return $this->unauthorized();
            }
            $user->delete();

            return $this->successResponse("Deleted  successfully", 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return $this->successResponse("restored successfully");
    }
}
