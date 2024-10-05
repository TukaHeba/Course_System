<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'experience' => $this->experience,
            'specialty' => $this->specialty,
            'courses' => CourseResource::collection($this->whenLoaded('courses')),
            'students' => StudentResource::collection($this->whenLoaded('students')),
        ];
    }
}
