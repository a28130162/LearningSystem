<?php

namespace App\Http\Livewire;

use Illuminate\Validation\Rule;
use App\Models\Classes;
use App\Models\Department;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;

    public $ModalFormVisible = false;
    public $ModelId;
    public $selectedDepartment = null;
    public $classes = null;
    public $disabled = 'disabled';
    public $hidden = '';
    public $classes_id;
    public $student_id;
    public $name;
    public $email;
    public $account_number;
    public $password;
    public $password_confirmation;
    public $role;

    public function rules()
    {
        if ($this->role == 'student') {
            return [
                'selectedDepartment' => 'required',
                'classes_id' => 'required',
                'student_id' => ['required', 'string', 'max:255', Rule::unique('users', 'student_id')->ignore($this->ModelId)],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->ModelId)],
                'account_number' => ['required', 'string', 'max:255', Rule::unique('users', 'account_number')->ignore($this->ModelId)],
                'password' => ['required', 'string'],
                'role' => 'required',
            ];
        } else {
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->ModelId)],
                'account_number' => ['required', 'string', 'max:255', Rule::unique('users', 'account_number')->ignore($this->ModelId)],
                'password' => ['required', 'string'],
                'role' => 'required',
            ];
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.user', [
            'data' => $this->read(),
            'departments' => Department::all(),
        ]);
    }

    public function read()
    {
        return ModelsUser::all()->paginate(10);
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
        ModelsUser::create($this->ModelData());
        $this->ModalFormVisible = false;
        $this->reset();
        session()->flash('message', '成功新增使用者');
    }

    public function ModelData()
    {
        return [
            'classes_id' => $this->classes_id,
            'student_id' => $this->student_id,
            'name' => $this->name,
            'email' => $this->email,
            'account_number' => $this->account_number,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ];
    }

    public function UpdataShowModal($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->ModelId = $id;
        $this->ModalFormVisible = true;
        $this->loadModel();
    }

    public function loadModel()
    {
        $data = ModelsUser::Find($this->ModelId);
        if (!is_null($data->classes_id)) {
            $this->selectedDepartment = $data->classes->department->id;
            $this->updatedSelectedDepartment($data->classes->department->id);
            $this->classes_id = $data->classes_id;
        }
        $this->student_id = $data->student_id;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->account_number = $data->account_number;
        $this->role = $data->role;
        $this->updatedRole($data->role);
    }

    public function Updata()
    {
        $this->validate();
        ModelsUser::Find($this->ModelId)->update($this->ModelData());
        $this->ModalFormVisible = false;
        $this->reset();
        session()->flash('message', '成功修改使用者資訊');
    }

    public function updatedSelectedDepartment($department_id)
    {
        $this->classes = Classes::where('department_id', $department_id)->get();
        if (is_null($department_id)) {
            $this->disabled = 'disabled';
        } elseif ($this->classes->count()) {
            $this->disabled = '';
        }
    }

    public function updatedRole($role)
    {
        if ($role == 'teacher' || $role == 'admin') {
            $this->hidden = 'hidden';
        } else {
            $this->hidden = '';
        }
    }
}
