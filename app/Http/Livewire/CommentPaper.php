<?php

namespace App\Http\Livewire;

use App\Models\CommentPaper as ModelsCommentPaper;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class CommentPaper extends Component
{
    use WithPagination;

    public $ModalFormVisible = false;
    public $ModalPreviewVisible = false;
    public $name;
    public $description;
    public $comment_paper_id;
    public $comment_projects = [];

    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('comment_papers', 'name')->ignore($this->comment_paper_id)],
            'description' => 'required',
            'comment_projects.*.name' => 'required',
            'comment_projects.*.project_contents.*.dimension' => 'required',
            'comment_projects.*.project_contents.*.level_content' => 'required',
        ];
    }

    public function mount()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.comment-paper', [
            'data' => $this->read(),
        ]);
    }

    public function read()
    {
        return ModelsCommentPaper::orderBy('name')->get()->paginate(10);
    }

    public function CreateShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->comment_projects[] = [
            'name' => '',
            'project_contents' => [[
                'dimension' => '',
                'level_content' => '',
            ]],
        ];
        $this->ModalFormVisible = true;
    }

    public function Create()
    {
        $this->validate();
        $comment_paper = ModelsCommentPaper::create($this->Modeldata());
        foreach ($this->comment_projects as $comment_project) {
            $new_comment_project = $comment_paper->comment_projects()->create([
                'name' => $comment_project['name'],
            ]);
            foreach ($comment_project['project_contents'] as $project_content) {
                $new_comment_project->project_contents()->create([
                    'dimension' => $project_content['dimension'],
                    'level_content' => $project_content['level_content'],
                ]);
            }
        }
        $this->ModalFormVisible = false;
        $this->reset();
        session()->flash('message', '成功新增試卷');
    }

    public function Modeldata()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    public function UpdataShowModal($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->comment_paper_id = $id;
        $this->ModalFormVisible = true;
        $this->loadModel();
    }

    public function loadModel()
    {
        $data = ModelsCommentPaper::find($this->comment_paper_id);
        $this->name = $data->name;
        $this->description = $data->description;
        if ($data->comment_projects()->get()->count() > 0) {
            foreach ($data->comment_projects()->get() as $index => $comment_projects_data) {
                $this->comment_projects[$index] = [
                    'name' => $comment_projects_data->name,
                    'project_contents' => [],
                ];
                if ($comment_projects_data->project_contents()->get()->count() > 0) {
                    foreach ($comment_projects_data->project_contents()->get() as $project_content) {
                        $this->comment_projects[$index]['project_contents'][] = [
                            'dimension' => $project_content->dimension,
                            'level_content' => $project_content->level_content,
                        ];
                    }
                }
            }
        }
    }

    public function Updata()
    {
        $this->validate();
        $comment_paper = ModelsCommentPaper::find($this->comment_paper_id);
        $comment_paper->update($this->Modeldata());
        foreach ($comment_paper->comment_projects() as $comment_project) {
            $comment_project->project_contents()->delete();
        }
        $comment_paper->comment_projects()->delete();
        foreach ($this->comment_projects as $comment_project) {
            $new_comment_project = $comment_paper->comment_projects()->create([
                'name' => $comment_project['name'],
            ]);
            foreach ($comment_project['project_contents'] as $project_content) {
                $new_comment_project->project_contents()->create([
                    'dimension' => $project_content['dimension'],
                    'level_content' => $project_content['level_content'],
                ]);
            }
        }
        $this->ModalFormVisible = false;
        $this->reset();
        session()->flash('message', '成功修改試卷');
    }

    public function addCommentProject()
    {
        $this->comment_projects[] = [
            'name' => '',
            'project_contents' => [[
                'dimension' => '',
                'level_content' => '',
            ]],
        ];
    }
    public function addProjectContent($index)
    {
        $this->comment_projects[$index]['project_contents'][] = [
            'dimension' => '',
            'level_content' => '',
        ];
    }

    public function removeCommentProject($index)
    {
        unset($this->comment_projects[$index]);
        $this->comment_projects = array_values($this->comment_projects);
    }

    public function removeProjectContent($index, $index2)
    {
        unset($this->comment_projects[$index]['project_contents'][$index2]);
        $this->comment_projects[$index]['project_contents'] = array_values($this->comment_projects[$index]['project_contents']);
    }

    public function comment_paper_preview($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->comment_paper_id = $id;
        $this->ModalPreviewVisible = true;
        $this->loadModel();
    }
}
