<?php

namespace App\Http\Livewire;

use App\Models\CommentPaper;
use App\Models\Question as QuestionModel;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Question extends Component
{
    use WithPagination;

    public $ModalFormVisible = false;
    public $QuestionPreview = false;
    public $ModelId;
    public $comment_paper_id;
    public $subject_id;
    public $name;
    public $quiz_time;
    public $question_descriptions = [];
    public $case_informations = [];
    public $problem_assessments = [];
    public $problem_solveds = [];

    public function rules()
    {
        return [
            'subject_id' => 'required',
            'name' => ['required', Rule::unique('questions', 'name')->ignore($this->ModelId)],
            'quiz_time' => ['required', 'numeric'],
            'question_descriptions.*.title' => 'required',
            'question_descriptions.*.content' => 'required',
            'case_informations.*.title' => 'required',
            'case_informations.*.content' => 'required',
            'problem_assessments.*.title' => 'required',
            'problem_assessments.*.content' => 'required',
            'problem_solveds.*.title' => 'required',
            'problem_solveds.*.content' => 'required',
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
        return view('livewire.question', [
            'data' => $this->read(),
            'subjects' => Subject::all(),
            'comment_papers' => CommentPaper::all(),
        ]);
    }

    public function read()
    {
        return QuestionModel::orderBy('name')->get()->paginate(10);
    }

    public function CreateShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->question_descriptions[] = [
            'title' => '',
            'content' => '',
        ];
        $this->case_informations[] = [
            'title' => '',
            'content' => '',
            'video' => '',
        ];
        $this->problem_assessments[] = [
            'title' => '',
            'content' => '',
        ];
        $this->problem_solveds[] = [
            'title',
            'content',
        ];
        $this->ModalFormVisible = true;
    }

    public function Create()
    {
        $this->validate();
        $question = QuestionModel::create($this->Modeldata());
        foreach ($this->question_descriptions as $question_description) {
            $question->question_descriptions()->create([
                'title' => $question_description['title'],
                'content' => $question_description['content'],
            ]);
        }
        foreach ($this->case_informations as $case_information) {
            $question->case_informations()->create([
                'title' => $case_information['title'],
                'content' => $case_information['content'],
                'video' => $case_information['video'],
            ]);
        }
        foreach ($this->problem_assessments as $problem_assessment) {
            $question->problem_assessments()->create([
                'title' => $problem_assessment['title'],
                'content' => $problem_assessment['content'],
            ]);
        }
        foreach ($this->problem_solveds as $problem_solved) {
            $question->problem_solveds()->create([
                'title' => $problem_solved['title'],
                'content' => $problem_solved['content'],
            ]);
        }
        $this->ModalFormVisible = false;
        $this->reset();
        session()->flash('message', '成功新增個案');
    }

    public function Modeldata()
    {
        return [
            'comment_paper_id' => $this->comment_paper_id,
            'user_id' => Auth::user()->id,
            'subject_id' => $this->subject_id,
            'name' => $this->name,
            'quiz_time' => $this->quiz_time,
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
        $data = QuestionModel::Find($this->ModelId);
        $this->comment_paper_id = $data->comment_paper_id;
        $this->subject_id = $data->subject_id;
        $this->name = $data->name;
        $this->quiz_time = $data->quiz_time;
        if ($data->question_descriptions()->get()->count() > 0) {
            foreach ($data->question_descriptions()->get() as $question_description_data) {
                $this->question_descriptions[] = [
                    'title' => $question_description_data->title,
                    'content' => $question_description_data->content
                ];
            }
        }
        if ($data->case_informations()->get()->count() > 0) {
            foreach ($data->case_informations()->get() as $case_information_data) {
                $this->case_informations[] = [
                    'title' => $case_information_data->title,
                    'content' => $case_information_data->content,
                    'video' => $case_information_data->video,
                ];
            }
        }
        if ($data->problem_assessments()->get()->count() > 0) {
            foreach ($data->problem_assessments()->get() as $problem_assessment_data) {
                $this->problem_assessments[] = [
                    'title' => $problem_assessment_data->title,
                    'content' => $problem_assessment_data->content
                ];
            }
        }
        if ($data->problem_solveds()->get()->count() > 0) {
            foreach ($data->problem_solveds()->get() as $problem_solved_data) {
                $this->problem_solveds[] = [
                    'title' => $problem_solved_data->title,
                    'content' => $problem_solved_data->content
                ];
            }
        }
    }

    public function Updata()
    {
        $this->validate();
        $question = QuestionModel::find($this->ModelId);
        $question->update($this->Modeldata());
        foreach ($question->question_descriptions()->get() as $index => $question_description) {
            $question_description->update([
                'title' => $this->question_descriptions[$index]['title'],
                'content' => $this->question_descriptions[$index]['content'],
            ]);
        }

        foreach ($question->case_informations()->get() as $index => $case_information) {
            $case_information->update([
                'title' => $this->case_informations[$index]['title'],
                'content' => $this->case_informations[$index]['content'],
                'video' => $this->case_informations[$index]['video'],
            ]);
        }

        foreach ($question->problem_assessments()->get() as $index => $problem_assessment) {
            $problem_assessment->update([
                'title' => $this->problem_assessments[$index]['title'],
                'content' => $this->problem_assessments[$index]['content'],
            ]);
        }

        foreach ($question->problem_solveds()->get() as $index => $problem_solved) {
            $problem_solved->update([
                'title' => $this->problem_solveds[$index]['title'],
                'content' => $this->problem_solveds[$index]['content'],
            ]);
        }
        $this->ModalFormVisible = false;
        $this->reset();
        session()->flash('message', '成功修改個案');
    }

    public function addQuestionDescription()
    {
        $this->question_descriptions[] = [
            'title' => '',
            'content' => ''
        ];
    }

    public function addCaseInformation()
    {
        $this->case_informations[] = [
            'title' => '',
            'content' => '',
            'video' => ''
        ];
    }

    public function addProblemAssessment()
    {
        $this->problem_assessments[] = [
            'title' => '',
            'content' => ''
        ];
    }

    public function addProblemSolved()
    {
        $this->problem_solveds[] = [
            'title' => '',
            'content' => ''
        ];
    }

    public function removeQuestionDescription($index)
    {
        unset($this->question_descriptions[$index]);
        $this->question_descriptions = array_values($this->question_descriptions);
    }

    public function removeCaseInformation($index)
    {
        unset($this->case_informations[$index]);
        $this->case_informations = array_values($this->case_informations);
    }

    public function removeProblemAssessment($index)
    {
        unset($this->problem_assessments[$index]);
        $this->problem_assessments = array_values($this->problem_assessments);
    }

    public function removeProblemSolved($index)
    {
        unset($this->problem_solveds[$index]);
        $this->problem_solveds = array_values($this->problem_solveds);
    }

    public function question_preview($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->ModelId = $id;
        $this->QuestionPreview = true;
        $this->loadModel();
    }
}
