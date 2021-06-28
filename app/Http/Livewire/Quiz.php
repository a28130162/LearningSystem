<?php

namespace App\Http\Livewire;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Quiz extends Component
{
    public $course_id;
    public $question_id;
    public $quiz_time;
    public $start_time;
    public $end_time;
    public $problem_assessment_answers = [];
    public $problem_solved_answers = [];
    public $start_quiz = false;
    public $end_check_model = false;

    public function mount($course, $question)
    {
        $this->course_id = $course;
        $this->question_id = $question;
        if (!in_array(Auth::user()->id, Course::find($course)->users()->get()) || Auth::user()->role != 'admin') {
            return abort(403, '權限錯誤');
        }
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.quiz', [
            'data' => Question::find($this->question_id),
        ])->layout('layouts.quiz');
    }

    public function loadData()
    {
        $data = Question::find($this->question_id);
        $this->quiz_time = $data->quiz_time;
        return [
            'data' => $data,
        ];
    }

    public function start()
    {
        $this->start_time = now();
        $this->dispatchBrowserEvent('start_quiz');
        $this->start_quiz = true;

        $data = Question::find($this->question_id);
        if ($data->problem_assessments()->get()->count() > 0) {
            foreach ($data->case_informations()->get() as $index => $case_information) {
                foreach ($data->problem_assessments()->get() as $index2 => $problem_assessment) {
                    $this->problem_assessment_answers[$index][] = [
                        'content' => '',
                    ];
                }
            }
        }

        if ($data->problem_solveds()->get()->count() > 0) {
            foreach ($data->problem_solveds()->get() as $index => $problem_solved) {
                $this->problem_solved_answers[] = [
                    'content' => ''
                ];
            }
        }
    }

    public function end_check()
    {
        $this->end_check_model = true;
    }

    public function end()
    {
        $data = Question::find($this->question_id);
        $this->end_time = now();
        $this->dispatchBrowserEvent('end_quiz');
        $answer = Answer::create([
            'course_id' => $this->course_id,
            'question_id' => $data->id,
            'user_id' => Auth::user()->id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        if ($data->problem_assessments()->get()->count() > 0) {
            foreach ($data->case_informations()->get() as $index => $case_information) {
                foreach ($data->problem_assessments()->get() as $index2 => $problem_assessment) {
                    $problem_assessment->answers()->create([
                        'answer_id' => $answer->id,
                        'case_information_id' => $case_information->id,
                        'content' => $this->problem_assessment_answers[$index][$index2]['content'],
                    ]);
                }
            }
        }

        if ($data->problem_solveds()->get()->count() > 0) {
            foreach ($data->problem_solveds()->get() as $index => $problem_solved) {
                $problem_solved->answers()->create([
                    'answer_id' => $answer->id,
                    'content' => $this->problem_solved_answers[$index]['content'],
                ]);
            }
        }

        return redirect()->to(route('record'));
    }
}
