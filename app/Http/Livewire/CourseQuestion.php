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

    public function mount($course)
    {
        $this->course = $course;
        if (!in_array(Auth::user()->id, Course::find($course)->users()->get()) || Auth::user()->role != 'admin') {
            return abort(403, '權限錯誤');
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
