<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('作答紀錄') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="p-6 border-gray-200">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="ml-4 text-2xl text-gray-600 leading-7 font-semibold">
                                個案資訊
                            </div>
                        </div>
                    </div>

                    <div class="pl-16 pb-4 border-gray-200">
                        <div class="ml-4 text-xl text-gray-600 leading-7 font-semibold">
                            <p>個案名稱：{{ $questions->name }}</p>
                            <p>開始作答時間：{{ $answers->start_time }}</p>
                            <p>結束作答時間：{{ $answers->end_time }}</p>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-indigo-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div class="ml-4 text-2xl text-gray-600 leading-7 font-semibold">
                                案例資料
                            </div>
                        </div>
                        @foreach ($questions->case_informations as $case_information)
                            <div class="ml-16">
                                <div class="mt-4 text-xl text-gray-600 leading-7 font-semibold">
                                    {{ $case_information->title }}
                                </div>
                                <div class="mt-2 text-xl text-gray-600">
                                    {{ $case_information->content }}
                                </div>
                                @if ($case_information->video != '')
                                    <div class="mt-4">
                                        <div class="aspect-w-16 aspect-h-9">
                                            <iframe src="https://www.youtube.com/embed/{{ $case_information->video }}"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen></iframe>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="p-6 border-t border-gray-200">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-indigo-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            <div class="ml-4 text-2xl text-gray-600 leading-7 font-semibold">
                                作答內容
                            </div>
                        </div>
                        <div class="ml-16">
                            <div
                                class="mt-4 border-b-2 border-gray-200 text-xl text-gray-600 leading-7 font-semibold">
                                {{ __('問題評估') }}
                            </div>
                            @foreach ($questions->case_informations as $case_information)
                                <div class="ml-2">
                                    <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                        {{ __('資料來源：') . $case_information->title }}
                                    </div>
                                    @foreach ($questions->problem_assessments as $problem_assessment)
                                        <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                            {{ $problem_assessment->title }}
                                        </div>
                                        <div class="mt-2 text-lg text-gray-600">
                                            {{ $problem_assessment->content }}
                                        </div>
                                        <div class="mt-2 border border-gray-300">
                                            <div class="ml-2 mt-2 text-lg text-gray-600 leading-7 font-semibold">
                                                {{ __('作答內容：') }}
                                            </div>
                                            <textarea disabled
                                                style="resize:none;"
                                                class="block mb-2 mt-1 w-full border-none">{{ $answers->contents->where('question_type', 'ProblemAssessment')->where('question_id', $problem_assessment->id)->where('case_information_id', $case_information->id)->first()->content }}</textarea>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <div class="ml-16">
                            <div
                                class="mt-4 border-b-2 border-gray-200 text-xl text-gray-600 leading-7 font-semibold">
                                {{ __('問題解決') }}
                            </div>

                            <div class="ml-2">
                                @foreach ($questions->problem_solveds as $problem_solved)
                                    <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                        {{ $problem_solved->title }}
                                    </div>
                                    <div class="mt-2 text-lg text-gray-600">
                                        {{ $problem_solved->content }}
                                    </div>
                                    <div class="mt-2 border border-gray-300">
                                        <div class="ml-2 mt-2 text-lg text-gray-600 leading-7 font-semibold">
                                            {{ __('作答內容：') }}
                                        </div>
                                        <textarea disabled style="resize:none;"
                                            class="block mb-2 mt-1 w-full border-none">{{ $answers->contents->where('question_type', 'ProblemSolved')->where('question_id', $problem_solved->id)->first()->content }}</textarea>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-indigo-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <div class="ml-4 text-2xl text-gray-600 leading-7 font-semibold">
                                評論內容
                            </div>
                        </div>

                        <div class="ml-16">
                            @if ($questions->comment_paper_id == null)
                                <div class="mt-2 text-xl text-gray-600">
                                    此個案尚未指定評論試卷。
                                </div>
                            @else
                                @if ((Auth::user()->role == 'student'||Auth::user()->role == 'teacher') && $answers->comments->where('user_id', Auth::user()->id)->count() == 0 )
                                    <div class="mt-4 text-xl text-gray-600 leading-7 font-semibold">
                                        <x-jet-button wire:click="CreateShowModal">
                                            {{ __('進行評論') }}
                                        </x-jet-button>
                                    </div>
                                    <div class="mt-2 text-xl text-gray-600">
                                        進行評論後，可查看學生或老師評論紀錄。
                                    </div>
                                @else
                                    <div class="mt-4 text-xl text-gray-600 leading-7 font-semibold">
                                        @if ($answers->comments->isEmpty())
                                            <div class="mt-2 text-xl text-gray-600">
                                                本次作答未進行過任何評論。
                                            </div>
                                        @else
                                            @if($answers->comments->where('user_id',$answers->user_id)->count() > 0)
                                            <x-jet-button wire:click="StudentComment">
                                                {{ __('查看學生評論') }}
                                            </x-jet-button>
                                            @endif
                                            @if($answers->comments->where('user_id','<>',$answers->user_id)->count() > 0)
                                            <x-jet-button wire:click="TeacherComment">
                                                {{ __('查看老師評論') }}
                                            </x-jet-button>
                                            @endif
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                @if($questions->comment_paper_id != null)
                <x-jet-dialog-modal wire:model="ModalFormVisible">
                    @if (empty($comment_id))
                        <x-slot name="title">
                            {{ __('新增評論') }}
                        </x-slot>
                    @else
                        <x-slot name="title">
                            {{ __('查看評論') }}
                        </x-slot>
                    @endif

                    <x-slot name="content">
                        <div class="mt-4">
                            <div class="text-xl text-gray-600 leading-7 font-semibold">
                                <p>評論試卷名稱：{{ $questions->name }}</p>
                                <br>
                                <p>評分規準：{{ $comment_papers->description }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="mt-4 border-b-2 border-gray-200 text-xl text-gray-600 leading-7 font-semibold">
                                {{ __('評論內容') }}
                            </div>
                            @foreach ($comment_papers->comment_projects as $index => $comment_project)
                                <div class="ml-2">
                                    <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                        {{ $comment_project->name }}
                                    </div>
                                    @foreach ($comment_project->project_contents as $index2 => $project_content)
                                        <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                            <p>{{ $project_content->dimension }}</p>
                                        </div>
                                        <div class="mt-2 border border-gray-300">
                                            <div class="ml-2 mt-2 text-lg text-gray-600 leading-7 font-semibold">
                                                <p>{{__('表現等級內容：')}}</p>
                                            </div>
                                            <textarea disabled rows="4" style="{{empty($comment_id) ? '': 'resize:none;'}}"
                                            class="block mb-2 mt-1 w-full border-none">{{ $project_content->level_content }}</textarea>
                                        </div>
                                        <div class="mt-2 text-lg text-gray-600">
                                            <p>{{__('評論分數：')}}</p>
                                            <label class="inline-flex items-center">
                                                <input type="radio" {{$disabled}} wire:model="comments.{{$index}}.{{$index2}}.score" value="1">
                                                <span class="ml-2">1級</span>
                                            </label>
                                            <label class="inline-flex items-center ml-6">
                                                <input type="radio" {{$disabled}} wire:model="comments.{{$index}}.{{$index2}}.score" value="2">
                                                <span class="ml-2">2級</span>
                                            </label>
                                            <label class="inline-flex items-center ml-6">
                                                <input type="radio" {{$disabled}} wire:model="comments.{{$index}}.{{$index2}}.score" value="3">
                                                <span class="ml-2">3級</span>
                                            </label>
                                            <label class="inline-flex items-center ml-6">
                                                <input type="radio" {{$disabled}} wire:model="comments.{{$index}}.{{$index2}}.score" value="4">
                                                <span class="ml-2">4級</span>
                                            </label>
                                            @error('comments.' . $index .'.'. $index2 . '.score')
                                            <div>
                                                <span class="error">{{ $message }}</span>
                                            </div>
                                            @enderror
                                            <div class="mt-2 text-lg text-gray-600 leading-7 font-semibold">
                                                <p>{{__('備註：')}}</p>
                                            </div>
                                            <textarea {{$disabled}} style="{{empty($comment_id) ? '': 'resize:none;'}}"
                                            wire:model="comments.{{$index}}.{{$index2}}.remark"
                                            class="block mb-2 mt-1 w-full {{empty($comment_id) ? 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm' : 'border-none'}} "></textarea>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            <div class="ml-2">
                                <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                    {{ __('補充說明') }}
                                    <textarea {{$disabled}} wire:model="note" style="{{empty($comment_id) ? '': 'resize:none;'}}"
                                    class="block mb-2 mt-1 w-full {{empty($comment_id) ? 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm' : 'border-none'}} "></textarea>
                                </div>
                            </div>
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-secondary-button wire:click="$toggle('ModalFormVisible')" wire:loading.attr="disabled">
                            @if (empty($comment_id))
                            {{__('取消')}}
                            @else
                            {{ __('關閉') }}
                            @endif
                        </x-jet-secondary-button>

                        @if (empty($comment_id))
                            <x-jet-button class="ml-2" wire:click="Create" wire:loading.attr="disabled">
                                {{ __('新增評論') }}
                            </x-jet-button>
                        @endif

                    </x-slot>
                </x-jet-dialog-modal>
                @endif
            </div>
        </div>
    </div>
</div>
