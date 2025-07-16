<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'finish_date',
        'cost',
        'level',
        'teacher_id'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function students()
    {

        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'student_id');
    }
}
