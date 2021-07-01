<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Component;

class CourseQuestion extends Component
{
    use WithPagination;

    public $course;
    public $course_name;

    public function mount($course)
    {
        $this->course = $course;
        $this->course_name = Course::find($course)->name;
        if (Course::find($course)->users()->get()->where('id', Auth::user()->id)->count() == 0) {
            if (Auth::user()->role != 'admin') {
                return abort(403, '權限錯誤');
            }
        }
    }

    public function render()
    {
        return view('livewire.course-question', [
            'data' => $this->read(),
        ]);
    }

    public function read()
    {
        return Course::find($this->course)->questions()->paginate();
    }

    public function ToQuiz($id)
    {
        return redirect()->to(route('quiz', ['course' => $this->course, 'question' => $id]));
    }
}
