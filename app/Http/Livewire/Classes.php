<?php

namespace App\Http\Livewire;

use App\Models\Classes as ClassesModel;
use App\Models\Department;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Classes extends Component
{
    use WithPagination;

    public $ModalFormVisible = false;
    public $ModelId;
    public $department_id = null;
    public $name;

    public function rules()
    {
        return [
            'department_id' => 'required',
            'name' => [
                'required', Rule::unique('classes', 'name')->ignore($this->ModelId)->where('department_id', $this->department_id)
            ],
        ];
    }

    public function messages()
    {
        return [
            'department_id.required' => '請選擇科系',
            'name.required' => '請輸入班級名稱',
            'name.unique' => '此班級名稱已被使用',
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
        return view('livewire.classes', [
            'data' => $this->read(),
            'departments' => Department::all(),
        ]);
    }

    public function read()
    {
        return ClassesModel::paginate(10);
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
        ClassesModel::create($this->ModelData());
        $this->ModalFormVisible = false;
        $this->reset();
        session()->flash('message', '成功新增班級');
    }

    public function ModelData()
    {
        return [
            'department_id' => $this->department_id,
            'name' => $this->name,
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
        $data = ClassesModel::Find($this->ModelId);
        $this->department_id = $data->department_id;
        $this->name = $data->name;
    }

    public function Updata()
    {
        $this->validate();
        ClassesModel::find($this->ModelId)->update($this->ModelData());
        $this->ModalFormVisible = false;
        $this->reset();
        session()->flash('message', '成功修改班級');
    }
}
