<?php

namespace App\Http\Livewire;

use App\Models\Classes;
use App\Models\Department;
use Livewire\Component;

class RegisterInfo extends Component
{
    public $selectedDepartment = null;
    public $classes = null;
    public $disabled = 'disabled';

    public function render()
    {
        return view('livewire.register-info', [
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function updatedSelectedDepartment($department_id)
    {
        $this->classes = Classes::where('department_id', $department_id)->orderBy('name')->get();
        if (is_null($department_id)) {
            $this->disabled = 'disabled';
        } elseif ($this->classes->count()) {
            $this->disabled = '';
        }
    }
}
