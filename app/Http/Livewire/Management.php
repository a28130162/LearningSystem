<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Management extends Component
{
    public function render()
    {
        return view('livewire.management');
    }

    public function toDepartment()
    {
        return redirect()->to(route('department'));
    }

    public function toClasses()
    {
        return redirect()->to(route('classes'));
    }

    public function toUser()
    {
        return redirect()->to(route('user'));
    }

    public function toCourse()
    {
        return redirect()->to(route('course'));
    }

    public function toSubject()
    {
        return redirect()->to(route('subject'));
    }

    public function toQuestion()
    {
        return redirect()->to(route('question'));
    }

    public function toCommentPaper()
    {
        return redirect()->to(route('comment_paper'));
    }

    public function toRecord()
    {
        return redirect()->to(route('Record'));
    }
}
