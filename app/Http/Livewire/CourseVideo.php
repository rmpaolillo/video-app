<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Livewire\Component;

class CourseVideo extends Component
{
    public function mount()
    {
        $data = Course::where('id', 51)->get();
        dd($data);
        return;
    }

    public function render()
    {
        return view('livewire.course-video');
    }
}
