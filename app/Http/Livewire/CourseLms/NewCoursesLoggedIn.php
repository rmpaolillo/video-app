<?php

namespace App\Http\Livewire\CourseLms;

use App\Models\Course;
use Livewire\Component;
use App\Models\Attendance;
use Illuminate\Support\Arr;

class NewCoursesLoggedIn extends Component
{
    public $id_attendance;
    public $title;
    public $course_title;
    public $course_id;
    public $course_uuid;
    public $course_link_video;
    public $course_link_youtube;
    public $course_link_dispense;
    public $codice;
    public $videos_json;
    public $no_videos;
    public $dateTimeCompleted ='';
    public $completed = false;
    public $index;
    public $compliancePopup = false;
    public $isPlaying = false;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        if (Course::where('unique_id', $this->course_uuid)->doesntExist()) {
            abort(404);
        }

        $data = Course::where('unique_id', $this->course_uuid)->firstOrFail();
        $this->videos_json = $data->link_video;
        $this->no_videos = count(json_decode($this->videos_json));
        if (Attendance::where('codice', $this->codice)->where('course_uuid', $this->course_uuid)->exists()) {
            $recover = Attendance::where('codice', $this->codice)->where('course_uuid', $this->course_uuid)->firstOrFail();
            $this->id_attendance = $recover['id'];
            $this->codice = $recover['codice'];
            $this->course_id = $recover['course_id'];
            $this->course_uuid = $recover['course_uuid'];
            $this->index = $recover['index'];
            $this->videos_json = $recover['videos'];
            $this->completed = $recover['completed'];
            $this->dateTimeCompleted = $recover['dateTimeCompleted'];
            // dd($this->dateTimeCompleted);
        } else {
            $attendances = Attendance::Create([
                'codice' => $this->codice,
                'course_id' => $this->course_id,
                'course_uuid' => $this->course_uuid,
                'index' => 0,
                'videos' => $this->videos_json,
                'completed' => $this->completed,
                'dateTimeCompleted' => $this->dateTimeCompleted
            ]);
            $this->id_attendance = $attendances['id'];
            $this->codice = $attendances['codice'];
            $this->course_id = $attendances['course_id'];
            $this->course_uuid = $attendances['course_uuid'];
            $this->index = $attendances['index'];
            $this->videos_json = $attendances['videos'];
            $this->completed = $attendances['completed'];
            $this->dateTimeCompleted = $attendances['dateTimeCompleted'];
            // dd($attendances);
        }

        // dd($this->id_test, $this->questions_json, $this->no_questions, $this->course_id, $this->course_uuid, $this->index, $this->submitted, $this->submitted, $this->dateTimeSubmitted, $this->review, $this->totalScore, $this->blank, $this->wrongAnswers);
    }

    public function update($id_attendance, $codice, $course_id, $course_uuid, $index, $videos, $completed, $dateTimeCompleted)
    {
        // dd($id_attendance, $codice, $course_id, $course_uuid, $index, $videos, $completed, $dateTimeCompleted);
        $attendances = Attendance::where('id', $id_attendance)
            ->where('course_id', $course_id)
            ->update([
                'course_id' => $course_id,
                'course_uuid' => $course_uuid,
                'index' => $index,
                'videos' => $videos,
                'completed' => $completed,
                'dateTimeCompleted' => $dateTimeCompleted
            ]);
        $this->index = $index;
        // dd($attendances);
    }

    public function updated()
    {
        dd($this->index);
    }

    public function goToNext($index, $id_attendance, $course_id)
    {
        // dd($index+1);
        $this->index = $this->index+1;
        if ($this->index > count(json_decode($this->videos_json))-1) {
            // dd($this->index);
            // dd(count(json_decode($this->videos_json))-1);
            $this->index = $this->index-1;
            return;
        }
        $attendances = Attendance::where('id', $id_attendance)
            ->where('course_id', $course_id)
            ->update([
                'index' => $this->index
            ]);
    }

    public function goToPrevious($index, $id_attendance, $course_id)
    {
        $this->index = $this->index-1;
        if ($this->index < 0) {
            // dd($this->index);
            $this->index = $this->index+1;
            return;
        }
        $attendances = Attendance::where('id', $id_attendance)
            ->where('course_id', $course_id)
            ->update([
                'index' => $this->index
            ]);
    }

    public function setCompleted($index, $id_attendance)
    {
        $videos_array = json_decode($this->videos_json, true);
        Arr::set($videos_array[$index], 'completed', 1);
        $this->index = $index;
        $attendances = Attendance::where('id', $id_attendance)
        ->update([
            'videos' => json_encode($videos_array),
            'index' => $this->index
        ]);
        $this->emit('refreshComponent');
    }

    public function setUncompleted($index, $id_attendance)
    {
        $videos_array = json_decode($this->videos_json, true);
        Arr::set($videos_array[$index], 'completed', 0);
        $attendances = Attendance::where('id', $id_attendance)
        ->update([
            'videos' => json_encode($videos_array),
            'index' => $this->index
        ]);
        $this->emit('refreshComponent');
    }

    public function closeCompliance()
    {
        $this->compliancePopup = false;
    }

    public function openCompliance()
    {
        $this->compliancePopup = true;
    }

    public function forceReload()
    {
        return;
    }

    public function render()
    {
        return view('livewire.course-lms.new-courses-logged-in');
    }
}
