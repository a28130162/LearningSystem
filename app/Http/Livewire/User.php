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
                'student_id' => ['required', 'string', 'max:255', 'unique:users,student_id,' . $this->ModelId],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->ModelId],
                'account_number' => ['required', 'string', 'max:255', 'unique:users,account_number,' . $this->ModelId],
                'password' => ['required', 'string', 'max:255'],
                'role' => 'required',
            ];
        } else {
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->ModelId],
                'account_number' => ['required', 'string', 'max:255', 'unique:users,account_number,' . $this->ModelId],
                'password' => ['required', 'string', 'max:255'],
                'role' => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            'selectedDepartment.required' => '請選擇科系',
            'classes_id.required' => '請選擇班級',
            'student_id.required' => '請輸入學號',
            'student_id.string' => '請輸入字串',
            'student_id.max' => '最大字元數為255字元',
            'student_id.unique' => '此學號已被使用',
            'name.required' => '請輸入使用者名稱',
            'name.string' => '請輸入字串',
            'name.max' => '最大字元數為255字元',
            'email.required' => '請輸入電子信箱',
            'email.string' => '請輸入字串',
            'email.max' => '最大字元數為255字元',
            'email.unique' => '此電子信箱已被使用',
            'account_number.required' => '請輸入帳號',
            'account_number.string' => '請輸入字串',
            'account_number.max' => '最大字元數為255字元',
            'account_number.unique' => '此帳號名稱已被使用',
            'password.required' => '請輸入密碼',
            'password.string' => '請輸入字串',
            'password.max' => '最大字元數為255字元',
            'role.required' => '請選擇角色',
        ];
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
        if ($this->role == 'student') {
            return [
                'classes_id' => $this->classes_id,
                'student_id' => $this->student_id,
                'name' => $this->name,
                'email' => $this->email,
                'account_number' => $this->account_number,
                'password' => Hash::make($this->password),
                'role' => $this->role,
            ];
        } else {
            return [
                'name' => $this->name,
                'email' => $this->email,
                'account_number' => $this->account_number,
                'password' => Hash::make($this->password),
                'role' => $this->role,
            ];
        }
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
        if (!empty($data->classes_id)) {
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
