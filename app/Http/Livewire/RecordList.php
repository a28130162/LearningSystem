<?php

namespace App\Http\Livewire;

use App\Models\Answer;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Component;

class RecordList extends Component
{
    use WithPagination;

    public $selected_course;

    public function render()
    {
        if (Auth::user()->role == 'teacher') {
            $courses = User::find(Auth::user()->id)->courses_has()->orderBy('name')->get();
        } elseif (Auth::user()->role == 'admin') {
            $courses = Course::orderBy('name')->get();
        } else {
            $courses = null;
        }
        return view('livewire.record-list', [
            'data' => $this->read(),
            'courses' => $courses,
        ]);
    }

    public function read()
    {
        if (Auth::user()->role == 'student') {
            return Answer::where('user_id', Auth::user()->id)->paginate(10);
        } else if (Auth::user()->role == 'teacher' || Auth::user()->role == 'admin') {
            return Answer::where('course_id', $this->selected_course)->paginate(10);
        }
    }

    public function answer_content($id)
    {
        return redirect()->to(route('record-content', ['record' => $id]));
    }
}
