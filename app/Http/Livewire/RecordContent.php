<?php

namespace App\Http\Livewire;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\CommentPaper;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecordContent extends Component
{
    public $ModalFormVisible = false;
    public $record_id;
    public $comments = [];
    public $comment_id;
    public $note;
    public $disabled;

    public function rules()
    {
        return [
            'comments.*.*.score' => 'required',
        ];
    }

    public function mount($record)
    {
        $this->record_id = $record;
        if (Auth::user()->role == 'student') {
            if (Answer::find($record)->user_id !== Auth::user()->id) {
                return abort(403, '權限錯誤');
            }
        } elseif (Auth::user()->role == 'teacher') {
            if (Answer::find($record)->course()->first()->user_id !== Auth::user()->id) {
                return abort(403, '權限錯誤');
            }
        } elseif (Auth::user()->role != 'admin') {
            return abort(403, '權限錯誤');
        }
    }

    public function render()
    {
        $answer = Answer::find($this->record_id);
        $question = Question::find($answer->question_id);
        $comment_paper = CommentPaper::find($question->comment_paper_id);
        if ($answer->comments->where('user_id', Auth::user()->id)->count() > 0 || Auth::user()->role == 'admin') {
            $this->disabled = 'disabled';
        }
        return view('livewire.record-content', [
            'answers' => $answer,
            'questions' => $question,
            'comment_papers' => $comment_paper,
        ]);
    }

    public function CreateShowModal()
    {
        $this->resetValidation();
        if (Answer::find($this->record_id)->question()->first()->comment_paper_id != null) {
            $question = Answer::find($this->record_id)->question()->first();
            $comment_paper = CommentPaper::find($question->comment_paper_id);
            foreach ($comment_paper->comment_projects()->get() as $index => $comment_project) {
                foreach ($comment_project->project_contents()->get() as $index2 => $project_contnet) {
                    $this->comments[$index][] = [
                        'score' => '',
                        'remark' => '',
                    ];
                }
            }
        }
        $this->ModalFormVisible = true;
    }

    public function Create()
    {
        $this->validate();
        $answer = Answer::find($this->record_id);
        $question = Question::find($answer->question_id);
        $comment_paper = CommentPaper::find($question->comment_paper_id);
        $comment = Comment::create([
            'comment_paper_id' => $comment_paper->id,
            'answer_id' => $answer->id,
            'user_id' => Auth::user()->id,
            'note' => $this->note,
        ]);
        foreach ($comment_paper->comment_projects()->get() as $index => $comment_project) {
            foreach ($comment_project->project_contents()->get() as $index2 => $project_content) {
                $project_content->comments()->create([
                    'comment_id' => $comment->id,
                    'score' => $this->comments[$index][$index2]['score'],
                    'remark' => $this->comments[$index][$index2]['remark'],
                ]);
            }
        }
        $this->ModalFormVisible = false;
    }

    public function StudentComment()
    {
        $answer = Answer::find($this->record_id);
        $student_comment = $answer->comments()->where('user_id', $answer->user_id)->first();
        $this->comment_id = $student_comment->id;
        $this->loadModel();
        $this->ModalFormVisible = true;
    }

    public function TeacherComment()
    {
        $answer = Answer::find($this->record_id);
        $student_comment = $answer->comments()->where('user_id', '<>', $answer->user_id)->first();
        $this->comment_id = $student_comment->id;
        $this->loadModel();
        $this->ModalFormVisible = true;
    }

    public function loadModel()
    {
        $answer = Answer::find($this->record_id);
        $question = Question::find($answer->question_id);
        $comment_paper = CommentPaper::find($question->comment_paper_id);
        $comment = Comment::find($this->comment_id);
        $this->comments = [];
        $this->note = $comment->note;
        foreach ($comment_paper->comment_projects()->get() as $index => $comment_project) {
            foreach ($comment_project->project_contents()->get() as $index2 => $project_content) {
                $data = $comment->contents()->where('project_content_id', $project_content->id)->first();
                $this->comments[$index][$index2]['score'] = $data->score;
                $this->comments[$index][$index2]['remark'] = $data->remark;
            }
        }
    }
}
