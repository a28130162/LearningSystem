<?php

namespace App\Http\Livewire;

use App\Models\Subject as SubjectModel;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Subject extends Component
{
    use WithPagination;

    public $ModalFormVisible = false;
    public $ModelId;
    public $name;

    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('subjects', 'name')->ignore($this->ModelId)],
        ];
    }

    public function render()
    {
        return view('livewire.subject', [
            'data' => $this->read(),
        ]);
    }


    public function read()
    {
        return SubjectModel::paginate(10);
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
        SubjectModel::create($validatedData);
        $this->ModalFormVisible = false;
        $this->reset();
        session()->flash('message', '成功新增科目');
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
        $data = SubjectModel::Find($this->ModelId);
        $this->name = $data->name;
    }

    public function Updata()
    {
        $validatedData = $this->validate();
        SubjectModel::find($this->ModelId)->update($validatedData);
        $this->ModalFormVisible = false;
        $this->reset();
        session()->flash('message', '成功修改科目');
    }
}
