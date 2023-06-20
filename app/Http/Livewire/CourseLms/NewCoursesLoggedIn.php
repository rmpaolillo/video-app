<?php

namespace App\Http\Livewire\CourseLms;

use App\Models\Course;
use Livewire\Component;
use App\Models\Attendance;
use Carbon\CarbonInterval;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

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
    public $logs = [];
    public $dateTimeCompleted;
    public $completed = false;
    public $index;
    public $compliancePopup = false;
    public $isPlaying = false;
    public $ipAddress;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        if (Course::where('unique_id', $this->course_uuid)->doesntExist()) {
            abort(404);
        }

        $data = Course::where('unique_id', $this->course_uuid)->firstOrFail();
        $this->videos_json = $data->link_video;
        if (Attendance::where('codice', $this->codice)->where('course_uuid', $this->course_uuid)->exists()) {
            $recover = Attendance::where('codice', $this->codice)->where('course_uuid', $this->course_uuid)->firstOrFail();
            $this->id_attendance = $recover['id'];
            $this->codice = $recover['codice'];
            $this->course_id = $recover['course_id'];
            $this->course_uuid = $recover['course_uuid'];
            $this->index = $recover['index'];
            $this->videos_json = $recover['videos'];
            $this->logs = $recover['logs'];
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
                'logs' => $this->logs,
                'completato' => $this->completato,
                'dateTimeCompleted' => $this->dateTimeCompleted
            ]);
            $this->id_attendance = $attendances['id'];
            $this->codice = $attendances['codice'];
            $this->course_id = $attendances['course_id'];
            $this->course_uuid = $attendances['course_uuid'];
            $this->index = $attendances['index'];
            $this->videos_json = $attendances['videos'];
            $this->logs = $attendances['logs'];
            $this->completed = $attendances['comnpleted'];
            $this->dateTimeCompleted = $attendances['dateTimeCompleted'];
            // dd($attendances);
        }

        // dd($this->id_test, $this->questions_json, $this->no_questions, $this->course_id, $this->course_uuid, $this->index, $this->submitted, $this->submitted, $this->dateTimeSubmitted, $this->review, $this->totalScore, $this->blank, $this->wrongAnswers);
    }

    public function update($id_attendance, $codice, $course_id, $course_uuid, $index, $videos, $logs, $completed, $dateTimeCompleted)
    {
        // dd($id_attendance, $codice, $course_id, $course_uuid, $index, $videos, $completed, $dateTimeCompleted);
        $attendances = Attendance::where('id', $id_attendance)
            ->where('course_id', $course_id)
            ->update([
                'course_id' => $course_id,
                'course_uuid' => $course_uuid,
                'index' => $index,
                'videos' => $videos,
                'logs' => $logs,
                'completato' => $completed,
                'dateTimeCompleted' => $dateTimeCompleted
            ]);
        $this->index = $index;
        // dd($attendances);
    }

    public function updated()
    {
        dd($this->index);
    }

    public function appendLogs($index, $id_attendance, $currentTime, $annotation)
    {
        $ipAddress = $this->ipAddress;
        $dataOra =  Carbon::now("Europe/Rome")->format('Y-m-d h:i:s');
        $uuid = Str::uuid()->toString();
        $this->logs = Attendance::where('id', $id_attendance)->pluck('logs')->firstOrFail();
        $logs_array = json_decode($this->logs, true);
        // dd($logs_array);
        // dd($this->logs);
        // dd($index, $id_attendance, $currentTime, $dataOra, $ipAddress, $annotation);
        // $logs_array = $this->logs;
        array_push($logs_array, [
            'id' => $uuid,
            'Data e Ora' => $dataOra,
            'Indirizzo IP' => $ipAddress,
            'Video/Modulo' => $index+1,
            'Istante Video' => CarbonInterval::seconds($currentTime)->cascade()->forHumans(),
            'Tipo Attività' => $annotation
        ]);
        // Arr::prepend($logs_array, $dataOra, $ipAddress, 'istante video: '.$currentTime, 'azione: '.$annotation);
        $attendances = Attendance::where('id', $id_attendance)
        ->update([
            'logs' => $logs_array,
        ]);
        // dd($attendances);
        $this->refreshSelected($id_attendance);
    }

    public function updateCompletedTime($index, $id_attendance, $currentTime)
    {
        $videos_array = json_decode($this->videos_json, true);
        // dd($index, $id_attendance, $currentTime);
        Arr::set($videos_array[$index], 'tempoCompletato', $currentTime);
        $attendances = Attendance::where('id', $id_attendance)
        ->update([
            'videos' => json_encode($videos_array),
        ]);
        $this->refreshSelected($id_attendance);
    }

    public function goTo($index, $id_attendance, $course_id)
    {
        $this->index = $index;
        $attendances = Attendance::where('id', $id_attendance)
        ->where('course_id', $course_id)
        ->update([
            'index' => $this->index
        ]);
        $this->dispatchBrowserEvent('notify');
    }

    public function goToNext($index, $id_attendance, $course_id)
    {
        if ($this->index > count(json_decode($this->videos_json))-1) {
            $this->index = $index-1;
            return;
        }
        $this->index = $index+1;
        $attendances = Attendance::where('id', $id_attendance)
        ->where('course_id', $course_id)
        ->update([
            'index' => $this->index
        ]);
        $this->dispatchBrowserEvent('notify');
        // dd($this->videos_json);
        // dd($this->index, $id_attendance, $course_id, $attendances);
    }

    public function goToPrevious($index, $id_attendance, $course_id)
    {
        // dd($this->videos_json);
        $this->index = $index-1;
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
        $this->dispatchBrowserEvent('notify');
    }

    public function setCompleted($index, $id_attendance)
    {
        $videos_array = json_decode($this->videos_json, true);
        if ($index == (count($videos_array)-1)) {
            $this->completed = 1;
            $this->dateTimeCompleted = Carbon::now()->format('Y-m-d H:i');
        }
        Arr::set($videos_array[$index], 'completato', 1);
        $attendances = Attendance::where('id', $id_attendance)
        ->update([
            'videos' => json_encode($videos_array),
            'index' => $this->index,
            'completed' => $this->completed,
            'dateTimeCompleted' => $this->dateTimeCompleted
        ]);
        // dd($attendances);
        $this->refreshSelected($id_attendance);
    }

    public function setUncompleted($index, $id_attendance)
    {
        $videos_array = json_decode($this->videos_json, true);
        if ($index == (count($videos_array)-1)) {
            $this->completed = 0;
        }
        Arr::set($videos_array[$index], 'completato', 0);
        Arr::set($videos_array[$index], 'tempoCompletato', 0);
        $attendances = Attendance::where('id', $id_attendance)
        ->update([
            'videos' => json_encode($videos_array),
            'index' => $this->index,
            'completed' => $this->completed,
            'dateTimeCompleted' => null
        ]);
        $this->refreshSelected($id_attendance);
    }

    public function refreshSelected($id_attendance)
    {
        $recover = Attendance::where('id', $id_attendance)->firstOrFail();
        $this->id_attendance = $recover['id'];
        $this->codice = $recover['codice'];
        $this->course_id = $recover['course_id'];
        $this->course_uuid = $recover['course_uuid'];
        $this->index = $recover['index'];
        $this->videos_json = $recover['videos'];
        $this->completed = $recover['completed'];
        $this->dateTimeCompleted = $recover['dateTimeCompleted'];
    }

    public function closeCompliance($key, $id_attendance)
    {
        $videos_array = json_decode($this->videos_json, true);
        Arr::set($videos_array[$this->index]['checkPoints'][$key], 'checkPassed', 'true');
        $attendances = Attendance::where('id', $id_attendance)
        ->update([
            'videos' => json_encode($videos_array),
            'index' => $this->index,
            'completed' => $this->completed,
            'dateTimeCompleted' => null
        ]);
        // dd(Arr::set($videos_array[$this->index]['checkPoints'][$key], 'checkPassed', 'true'));
        // return redirect(request()->header('Referer'));
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
