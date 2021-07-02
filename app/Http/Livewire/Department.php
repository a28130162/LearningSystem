<?php

namespace App\Http\Livewire;

use App\Models\Department as DepartmentModel;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Department extends Component
{
    use WithPagination;

    public $ModalFormVisible = false;
    public $ModelId;
    public $name;

    public function rules()
    {
        return [
            'name' => ['required', 'unique:departments,name,' . $this->ModelId],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '請輸入科系名稱',
            'name.unique' => '此科系名稱已被使用',
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
        return view('livewire.department', [
            'data' => $this->read(),
        ]);
    }

    public function read()
    {
        return DepartmentModel::paginate(10);
    }

    public function CreateShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->ModalFormVisible = true;
    }

    public function Create()
    {
        $validatedData = $this->validate();
        DepartmentModel::create($validatedData);
        $this->ModalFormVisible = false;
        $this->reset();
        session()->flash('message', '成功新增科系');
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
        $data = DepartmentModel::Find($this->ModelId);
        $this->name = $data->name;
    }

    public function Updata()
    {
        $validatedData = $this->validate();
        DepartmentModel::find($this->ModelId)->update($validatedData);
        $this->ModalFormVisible = false;
        $this->reset();
        session()->flash('message', '成功修改科系');
    }
}
