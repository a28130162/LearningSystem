<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class CourseEdit extends Component
{
    use WithPagination;

    public $course_Id;
    public $data;
    public $name;
    public $student_id = [];
    public $student = [];
    public $selected_student_id;
    public $selected_question_id;
    public $selected_questions = [];
    public $ModelStudentVisable = false;
    public $ModalQuestionVisible = false;
    public $ModelDeleteVisible = false;
    public $ModelDeleteQuestionVisible = false;

    public function mount($course)
    {
        $this->course_Id = $course;
        if (Course::find($course)->user_id !== Auth::user()->id || Auth::user()->role != 'admin') {
            return abort(403, '權限錯誤');
        }
        $this->resetPage();
    }

    public function render()
    {
        $this->data = Course::find($this->course_Id);
        $this->name = Course::find($this->course_Id)->name;
        return view('livewire.course-edit', [
            'questions' => Question::paginate(10),
        ]);
    }

    public function course_update()
    {
        $validatedData = $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('courses', 'name')->ignore($this->course_Id)]
        ]);
        $this->data->update($validatedData);
        session()->flash('course_saved', '已更新課程資訊');
    }

    public function add_student_model()
    {
        $this->resetValidation();
        $this->student_id = [[
            'student' => '',
        ]];
        $this->student = [];
        $this->ModelStudentVisable = true;
    }

    public function add_student()
    {
        $validatedData = $this->validate([
            'student_id.*.student_id' => ['required', 'string', 'max:255', 'exists:users,student_id',],
        ]);
        foreach ($this->student_id as $index => $student) {
            $this->student[$index]['id'] = User::where('student_id', $this->student_id[$index]['student_id'])->first()->id;
        }
        $validatedData2 = $this->validate([
            'student.*.id' => [Rule::unique('course_user', 'user_id')->where('course_id', $this->course_Id)],
        ]);
        foreach ($this->student as $index => $student_id) {
            $this->data->users()->attach($this->student[$index]['id']);
        }
        session()->flash('success_add', '成功新增學生');
        $this->student_id = [];
        $this->student = [];
        $this->ModelStudentVisable = false;
    }

    public function more_student()
    {
        $this->student_id[] = [
            'student_id' => '',
        ];
    }

    public function unset_student($index)
    {
        unset($this->student_id[$index]);
        $this->student_id = array_values($this->student_id);
    }

    public function leave_confirm($id)
    {
        $this->selected_student_id = $id;
        $this->ModelDeleteVisible = true;
    }

    public function leave_course()
    {
        $this->data->users()->detach($this->selected_student_id);
        $this->selected_student_id = '';
        $this->ModelDeleteVisible = false;
    }

    public function question_management()
    {
        $course_questions = [];
        $this->selected_questions = [];
        foreach ($this->data->questions()->get() as $question) {
            $course_questions[] = $question->id;
        }
        foreach (Question::all() as $question) {
            if (in_array($question->id, $course_questions)) {
                $this->selected_questions[$question->id] = true;
            } else {
                $this->selected_questions[$question->id] = false;
            }
        }
        $this->ModalQuestionVisible = true;
    }

    public function question_save()
    {
        $select = array_search(true, $this->selected_questions);
        $this->data->questions()->sync($select);
        session()->flash('question_saved', '成功修改課程個案');
        $this->ModalQuestionVisible = false;
    }

    public function unset_question_model($id)
    {
        $this->selected_question_id = $id;
        $this->ModelDeleteQuestionVisible = true;
    }

    public function unset_question()
    {
        $this->data->questions()->detach($this->selected_question_id);
        $this->selected_question_id = '';
        $this->ModelDeleteQuestionVisible = false;
    }
}
