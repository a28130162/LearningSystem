<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class CourseList extends Component
{
    use WithPagination;

    public $ModalFormVisible = false;
    public $user_id;
    public $name;

    public function rules()
    {
        if (Auth::user()->role == 'admin') {
            return [
                'user_id' => 'required',
                'name' => ['required', 'unique:courses,name'],
            ];
        } else {
            return [
                'name' => ['required', 'unique:courses,name'],
            ];
        }
    }

    public function messages()
    {
        return [
            'user_id.required' => '請選擇課程指導老師',
            'name.required' => '請輸入課程名稱',
            'name.unique' => '此課程名稱已被使用',
        ];
    }

    public function mount()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.course-list', [
            'data' => $this->read(),
            'teachers' => User::where('role', 'teacher')->get(),
        ]);
    }

    public function CreateShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->ModalFormVisible = true;
    }

    public function Create()
    {
        $this->validate();
        Course::create($this->modelData());
        $this->ModalFormVisible = false;
        $this->reset();
        session()->flash('message', '成功新增課程');
    }

    public function modelData()
    {
        if (empty($this->user_id)) {
            return [
                'user_id' => Auth::user()->id,
                'name' => $this->name,
            ];
        } else {
            return [
                'user_id' => $this->user_id,
                'name' => $this->name,
            ];
        }
    }

    public function read()
    {
        if (Auth::user()->role == 'student') {
            return Auth::user()->courses->paginate();
        } elseif (Auth::user()->role == 'teacher') {
            return Auth::user()->courses_has->paginate();
        } elseif (Auth::user()->role == 'admin') {
            return Course::paginate();
        }
    }

    public function ToCourseQuestion($id)
    {
        return redirect()->to(route('course-question', ['course' => $id]));
    }

    public function ToEdit($id)
    {
        return redirect()->to(route('course-edit', ['course' => $id]));
    }
}
