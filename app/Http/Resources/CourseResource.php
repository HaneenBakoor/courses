<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id'=>$this->id,
            'title' => $this->title,
            'description' => $this->description,
            'level' => $this->level,
            'start_date' => $this->start_date,
            'finish_date' => $this->finish_date,
            'cost' => $this->cost,
            'created_at' => $this->created_at->format('Y-m-d'),
            'teacher' => $this->teacher->name
        ];
    }
}
