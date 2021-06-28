<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('個案管理') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session()->has('message'))
                    <div class="pb-4">
                        <div class="p-3 bg-green-100 text-green-700 rounded shadow-sm">
                            {{ session('message') }}
                        </div>
                    </div>
                @endif
                <x-jet-button wire:click="CreateShowModal">
                    {{ __('新增個案') }}
                </x-jet-button>
                <div class="flex flex-wrap py-6">
                    <table class="table-auto w-full text-left whitespace-no-wrap py-6 ">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100 rounded-tl rounded-bl">
                                    科目名稱</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                    個案名稱</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                    新增日期</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                    修改日期</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data->count())
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ $item->subject->name }}
                                        </td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ $item->name }}</td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ $item->created_at }}</td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ $item->updated_at }}</td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">
                                            <x-jet-button wire:click="question_preview({{ $item->id }})">
                                                {{ __('預覽') }}
                                            </x-jet-button>
                                            <x-jet-button wire:click="UpdataShowModal({{ $item->id }})">
                                                {{ __('修改') }}
                                            </x-jet-button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">
                                        <div class="p-3 bg-gray-50 text-gray-700 rounded shadow-sm">
                                            {{ __('未查詢到任何個案') }}
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    {{ $data->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                {{-- 表單 --}}
                <x-jet-dialog-modal wire:model="ModalFormVisible">
                    @if (empty($ModelId))
                        <x-slot name="title">
                            {{ __('新增個案') }}
                        </x-slot>
                    @else
                        <x-slot name="title">
                            {{ __('修改個案') }}
                        </x-slot>
                    @endif

                    <x-slot name="content">
                        <div class="mt-4">
                            <x-jet-label for="subject" value="{{ __('科目') }}" />
                            <select id="subject" wire:model="subject_id" class=" block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 round
                                leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                @if (empty($subject_id))
                                    <option value="">-- 選擇科目 --</option>
                                @endif
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                                @error('subject_id') <span class="error">{{ $message }}</span> @enderror
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="name" value="{{ __('個案名稱') }}" />
                            <x-jet-input id="name" class="block mt-1 w-full" type="text"
                                wire:model.debounce.500ms="name" />
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="quiz_time" value="{{ __('測驗時間(分鐘)') }}" />
                            <x-jet-input id="quiz_time" class="block mt-1 w-full" type="text"
                                wire:model.debounce.500ms="quiz_time" />
                            @error('quiz_time') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="comment_paper" value="{{ __('所採用評論試卷') }}" />
                            <select id="comment_paper" wire:model="comment_paper_id" class=" block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 round
                                leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                @if (empty($comment_paper_id))
                                    <option value="">-- 選擇評論試卷 --</option>
                                @endif
                                @foreach ($comment_papers as $comment_paper)
                                    <option value="{{ $comment_paper->id }}">{{ $comment_paper->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="question_description" value="{{ __('作答說明') }}" />
                            @foreach ($question_descriptions as $index => $question_description)
                                <div class="py-2 w-full">
                                    <div
                                        class="h-full p-6 mt-1 w-full rounded-md shadow-sm bg-gray-50 border-gray-300 flex flex-col relative overflow-hidden">
                                        @if (empty($ModelId) && count($question_descriptions) > 1)
                                            <button wire:click="removeQuestionDescription({{ $index }})">
                                                <span
                                                    class="bg-red-500 text-white px-4 py-2 tracking-widest text-xs absolute right-0 top-0 rounded-bl">刪除</span>
                                            </button>
                                        @endif
                                        <div class="mt-4">
                                            <x-jet-label for="question_descriptions.{{ $index }}.title"
                                                value="{{ __('標題') }}" />
                                            <x-jet-input id="question_descriptions.{{ $index }}.title"
                                                class="block mt-1 w-full" type="text"
                                                wire:model.debounce.500ms="question_descriptions.{{ $index }}.title" />
                                            @error('question_descriptions.' . $index . '.title')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mt-4">
                                            <x-jet-label for="question_descriptions.{{ $index }}.content"
                                                value="{{ __('內容') }}" />
                                            <textarea id="question_descriptions.{{ $index }}.content"
                                                wire:model.debounce.99999999ms="question_descriptions.{{ $index }}.content"
                                                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                                rows="5">
                                            </textarea>
                                            @error('question_descriptions.' . $index . '.content')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if (empty($ModelId))
                                <x-jet-button class="my-4" wire:click="addQuestionDescription"
                                    wire:loading.attr="disabled">
                                    {{ __('新增作答說明') }}
                                </x-jet-button>
                            @endif
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="case_informations" value="{{ __('案例資料') }}" />
                            @foreach ($case_informations as $index => $case_information)
                                <div class="py-2 w-full">
                                    <div
                                        class="h-full p-6 mt-1 w-full rounded-md shadow-sm bg-gray-50 border-gray-300 flex flex-col relative overflow-hidden">
                                        @if (empty($ModelId) && count($case_informations) > 1)
                                            <button wire:click="removeCaseInformation({{ $index }})">
                                                <span
                                                    class="bg-red-500 text-white px-4 py-2 tracking-widest text-xs absolute right-0 top-0 rounded-bl">刪除</span>
                                            </button>
                                        @endif
                                        <div class="mt-4">
                                            <x-jet-label for="case_informations.{{ $index }}.title"
                                                value="{{ __('標題') }}" />
                                            <x-jet-input id="case_informations.{{ $index }}.title"
                                                class="block mt-1 w-full" type="text"
                                                wire:model.debounce.500ms="case_informations.{{ $index }}.title" />
                                            @error('case_informations.' . $index . '.title')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mt-4">
                                            <x-jet-label for="case_informations.{{ $index }}.content"
                                                value="{{ __('內容') }}" />
                                            <textarea id="case_informations.{{ $index }}.content"
                                                wire:model.debounce.99999999ms="case_informations.{{ $index }}.content"
                                                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                                rows="5">
                                            </textarea>
                                            @error('case_informations.' . $index . '.content')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mt-4">
                                            <x-jet-label for="case_informations.{{ $index }}.video"
                                                value="{{ __('影片ID(可空值)') }}" />
                                            <x-jet-input id="case_informations.{{ $index }}.video"
                                                class="block mt-1 w-full" type="text"
                                                wire:model.debounce.500ms="case_informations.{{ $index }}.video" />
                                            @error('case_informations.' . $index . '.video')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if (empty($ModelId))
                                <x-jet-button class="my-4" wire:click="addCaseInformation" wire:loading.attr="disabled">
                                    {{ __('新增案例資料') }}
                                </x-jet-button>
                            @endif
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="problem_assessment" value="{{ __('問題評估') }}" />
                            @foreach ($problem_assessments as $index => $problem_assessment)
                                <div class="py-2 w-full">
                                    <div
                                        class="h-full p-6 mt-1 w-full rounded-md shadow-sm bg-gray-50 border-gray-300 flex flex-col relative overflow-hidden">
                                        @if (empty($ModelId) && count($problem_assessments) > 1)
                                            <button wire:click="removeProblemAssessment({{ $index }})">
                                                <span
                                                    class="bg-red-500 text-white px-4 py-2 tracking-widest text-xs absolute right-0 top-0 rounded-bl">刪除</span>
                                            </button>
                                        @endif
                                        <div class="mt-4">
                                            <x-jet-label for="problem_assessments.{{ $index }}.title"
                                                value="{{ __('標題') }}" />
                                            <x-jet-input id="problem_assessments.{{ $index }}.title"
                                                class="block mt-1 w-full" type="text"
                                                wire:model.debounce.500ms="problem_assessments.{{ $index }}.title" />
                                            @error('problem_assessments.' . $index . '.title')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mt-4">
                                            <x-jet-label for="problem_assessments.{{ $index }}.content"
                                                value="{{ __('內容') }}" />
                                            <textarea id="problem_assessments.{{ $index }}.content"
                                                wire:model.debounce.99999999ms="problem_assessments.{{ $index }}.content"
                                                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                                rows="5">
                                            </textarea>
                                            @error('problem_assessments.' . $index . '.content')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if (empty($ModelId))
                                <x-jet-button class="my-4" wire:click="addProblemAssessment"
                                    wire:loading.attr="disabled">
                                    {{ __('新增問題評估') }}
                                </x-jet-button>
                            @endif
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="problem_solved" value="{{ __('問題解決') }}" />
                            @foreach ($problem_solveds as $index => $problem_solved)
                                <div class="py-2 w-full">
                                    <div
                                        class="h-full p-6 mt-1 w-full rounded-md shadow-sm bg-gray-50 border-gray-300 flex flex-col relative overflow-hidden">
                                        @if (empty($ModelId) && count($problem_solveds) > 1)
                                            <button wire:click="removeProblemSolved({{ $index }})">
                                                <span
                                                    class="bg-red-500 text-white px-4 py-2 tracking-widest text-xs absolute right-0 top-0 rounded-bl">刪除</span>
                                            </button>
                                        @endif
                                        <div class="mt-4">
                                            <x-jet-label for="problem_solveds.{{ $index }}.title"
                                                value="{{ __('標題') }}" />
                                            <x-jet-input id="problem_solveds.{{ $index }}.title"
                                                class="block mt-1 w-full" type="text"
                                                wire:model.debounce.500ms="problem_solveds.{{ $index }}.title" />
                                            @error('problem_solveds.' . $index . '.title')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mt-4">
                                            <x-jet-label for="problem_solveds.{{ $index }}.content"
                                                value="{{ __('內容') }}" />
                                            <textarea id="problem_solveds.{{ $index }}.content"
                                                wire:model.debounce.99999999ms="problem_solveds.{{ $index }}.content"
                                                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                                rows="5">
                                            </textarea>
                                            @error('problem_solveds.' . $index . '.content')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if (empty($ModelId))
                                <x-jet-button class="my-4" wire:click="addProblemSolved" wire:loading.attr="disabled">
                                    {{ __('新增問題解決') }}
                                </x-jet-button>
                            @endif
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-secondary-button wire:click="$toggle('ModalFormVisible')" wire:loading.attr="disabled">
                            {{ __('取消') }}
                        </x-jet-secondary-button>

                        @if (empty($ModelId))
                            <x-jet-button class="ml-2" wire:click="Create" wire:loading.attr="disabled">
                                {{ __('創建') }}
                            </x-jet-button>
                        @else
                            <x-jet-button class="ml-2" wire:click="Updata" wire:loading.attr="disabled">
                                {{ __('修改') }}
                            </x-jet-button>
                        @endif

                    </x-slot>
                </x-jet-dialog-modal>

                @if($data->count())
                <x-jet-dialog-modal wire:model="QuestionPreview">

                    <x-slot name="title">
                        {{ __('預覽個案') }}
                    </x-slot>

                    <x-slot name="content">
                        <div class="mt-4">
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
                                <div class="ml-4 text-2xl text-gray-600 leading-7 font-semibold">
                                    <p>個案名稱：{{ $name }}<span class="ml-10">作答時間：{{ $quiz_time }}分鐘</span>
                                    </p>
                                </div>
                            </div>

                            <div class="p-6 border-t border-gray-200">
                                <div class="flex items-center">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewBox="0 0 24 24" class="w-10 h-10 text-indigo-700">
                                        <path
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <div class="ml-4 text-2xl text-gray-600 leading-7 font-semibold">
                                        作答說明
                                    </div>
                                </div>

                                @foreach ($question_descriptions as $index => $question_description)
                                    <div class="ml-16">
                                        <div class="mt-4 text-xl text-gray-600 leading-7 font-semibold">
                                            {{ $question_descriptions[$index]['title'] }}
                                        </div>
                                        <div class="mt-2 text-xl text-gray-600">
                                            {{ $question_descriptions[$index]['content'] }}
                                        </div>
                                    </div>
                                @endforeach
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
                                @foreach ($case_informations as $index => $case_information)
                                    <div class="ml-16">
                                        <div class="mt-4 text-xl text-gray-600 leading-7 font-semibold">
                                            {{ $case_informations[$index]['title'] }}
                                        </div>
                                        <div class="mt-2 text-xl text-gray-600">
                                            {{ $case_informations[$index]['content'] }}
                                        </div>
                                        @if ($case_informations[$index]['video'] != '')
                                            <div class="mt-4">
                                                <div class="aspect-w-16 aspect-h-9">
                                                    <iframe src="https://www.youtube.com/embed/{{ $case_informations[$index]['video'] }}"
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
                                    @foreach ($case_informations as $index => $case_information)
                                        <div class="ml-2">
                                            <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                                {{ __('資料來源：') . $case_informations[$index]['title'] }}
                                            </div>
                                            @foreach ($problem_assessments as $index2 => $problem_assessment)
                                                <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                                    {{ $problem_assessments[$index2]['title'] }}
                                                </div>
                                                <div class="mt-2 text-lg text-gray-600">
                                                    {{ $problem_assessments[$index2]['content'] }}
                                                </div>
                                                <div class="mt-2">
                                                    <textarea
                                                        class="block mb-2 mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
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
                                        @foreach ($problem_solveds as $index => $problem_solved)
                                            <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                                {{ $problem_solveds[$index]['title'] }}
                                            </div>
                                            <div class="mt-2 text-lg text-gray-600">
                                                {{ $problem_solveds[$index]['content'] }}
                                            </div>
                                            <div class="mt-2">
                                                <textarea
                                                    class="block mb-2 mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-secondary-button wire:click="$toggle('QuestionPreview')" wire:loading.attr="disabled">
                            {{ __('關閉') }}
                        </x-jet-secondary-button>
                    </x-slot>
                </x-jet-dialog-modal>
                @endif
            </div>
        </div>
    </div>
</div>
