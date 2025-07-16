<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected function cost(): Attribute
    {
        return Attribute::make(
            get: fn($value) => number_format($value, 2) . '$',
            set: fn($value) => str_replace(['$', ','], '', $value)
        );
    }
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
