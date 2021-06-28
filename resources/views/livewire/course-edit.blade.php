<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('課程管理') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1 flex justify-between">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('課程資訊') }}</h3>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('課程名稱及指導老師') }}
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <x-jet-label value="{{ __('課程指導老師') }}" />

                                <div class="flex items-center mt-2">
                                    <div class="ml-4 leading-tight">
                                        <div>{{ $data->user->name }}</div>
                                        <div class="text-gray-700 text-sm">{{ $data->user->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-jet-label for="name" value="{{ __('課程名稱') }}" />

                                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name"
                                    :disabled="! (Auth::user()->role=='teacher'||'admin')" />
                                @error('name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                        <div class="mr-3">
                            @if (session()->has('course_saved'))
                                <div class="text-sm text-gray-600">
                                    {{ session('course_saved') }}
                                </div>
                            @endif
                        </div>
                        <x-jet-button wire:click="course_update">
                            {{ __('更新') }}
                        </x-jet-button>
                    </div>
                </div>
            </div>
        </div>

        <x-jet-section-border />
        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1 flex justify-between">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('管理課程學生') }}</h3>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('新增或移除課程學生') }}
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md">
                        <div class="space-y-6 flex items-center justify-start">
                            <x-jet-button wire:click="add_student_model">
                                {{ __('新增課程學生') }}
                            </x-jet-button>
                            <div class="ml-3">
                                @if (session()->has('success_add'))
                                    <div class="text-md items-center text-gray-600">
                                        {{ session('success_add') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if($data->users->isNotEmpty())
                            <div class="mt-4 space-y-6">
                                <div class="flex items-center justify-between text-gray-900 text-md bg-gray-50">
                                    <div class="flex-1 items-center px-4 py-3">
                                        <div class="ml-4">{{ __('學號') }}</div>
                                    </div>
                                    <div class="flex-1 items-center px-4 py-3">
                                        <div class="ml-4">{{ __('姓名') }}</div>
                                    </div>
                                    <div class="flex-1 items-center px-4 py-3">
                                    </div>
                                </div>
                                @foreach ($data->users->sortBy('name') as $user)
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 items-center px-4 py-3">
                                            <div class="ml-4">{{ $user->student_id }}</div>
                                        </div>
                                        <div class="flex-1 items-center px-4 py-3">
                                            <div class="ml-4">{{ $user->name }}</div>
                                        </div>
                                        <div class="flex-1 items-center px-4 py-3 text-center">
                                            <button class="cursor-pointer ml-6 text-sm text-red-500"
                                                wire:click="leave_confirm('{{ $user->id }}')">
                                                {{ __('刪除') }}
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <x-jet-section-border />
        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1 flex justify-between">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('管理課程個案') }}</h3>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('管理課程所屬個案') }}
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md">
                        <div class="space-y-6 flex items-center justify-start">
                            <x-jet-button wire:click="question_management">
                                {{ __('管理個案') }}
                            </x-jet-button>
                            <div class="ml-3">
                                @if (session()->has('question_saved'))
                                    <div class="text-md items-center text-gray-600">
                                        {{ session('question_saved') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if ($data->questions->isNotEmpty())
                            <div class="mt-4 space-y-6">
                                <div class="flex items-center justify-between text-gray-900 text-md bg-gray-50">
                                    <div class="flex-1 items-center px-4 py-3">
                                        <div class="ml-4">{{ __('科目') }}</div>
                                    </div>
                                    <div class="flex-1 items-center px-4 py-3">
                                        <div class="ml-4">{{ __('個案名稱') }}</div>
                                    </div>
                                    <div class="flex-1 items-center px-4 py-3">
                                    </div>
                                </div>
                                @foreach ($data->questions->sortBy('name') as $question)
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 items-center px-4 py-3">
                                            <div class="ml-4">{{ $question->subject->name }}</div>
                                        </div>
                                        <div class="flex-1 items-center px-4 py-3">
                                            <div class="ml-4">{{ $question->name }}</div>
                                        </div>
                                        <div class="flex-1 items-center px-4 py-3 text-center">
                                            <button class="cursor-pointer ml-6 text-sm text-red-500"
                                                wire:click="unset_question_model('{{ $question->id }}')">
                                                {{ __('刪除') }}
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <x-jet-dialog-modal wire:model="ModelStudentVisable" maxWidth="2xl">
            <x-slot name="title">
                {{ __('新增課程學生') }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                    <div class="mt-4">
                        <x-jet-label value="{{ __('請輸入學號') }}" />
                        @foreach($student_id as $index => $input_student)
                            <div class="py-1">
                                <div class="relative">
                                    <x-jet-input class="w-full" type="text"
                                        wire:model.debounce.500ms="student_id.{{$index}}.student_id" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                        <button wire:click="unset_student" class="text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @error('student_id.'.$index.'.student_id') <span class="error">{{ $message }}</span> @enderror
                                @error('student.'.$index.'.id') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        @endforeach
                        <button wire:click="more_student" class="mt-4 px-4 py-1 rounded bg-blue-600 text-blue-50 max-w-max">+ 更多學生</button>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('ModelStudentVisable')" wire:loading.attr="disabled">
                    {{ __('取消') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="add_student" wire:loading.attr="disabled">
                    {{ __('確定') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>

        <x-jet-dialog-modal wire:model="ModalQuestionVisible" maxWidth="2xl">
            <x-slot name="title">
                {{ __('管理課程個案') }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                    <div class="flex flex-wrap py-6">
                        <table class="table-auto w-full text-left whitespace-no-wrap py-6 ">
                            <thead>
                                <tr>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                        選擇個案</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                        科目名稱</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                        個案名稱</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($questions->count())
                                    @foreach ($questions as $question)
                                        <tr>
                                            <td class="border-t-2 border-gray-200 px-4 py-3">
                                                <x-jet-checkbox
                                                    wire:model="selected_questions.{{ $question->id }}" />
                                            </td>
                                            <td class="border-t-2 border-gray-200 px-4 py-3">
                                                {{ $question->subject->name }}
                                            </td>
                                            <td class="border-t-2 border-gray-200 px-4 py-3">
                                                {{ $question->name }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">
                                            <div class="p-3 bg-gray-50 text-gray-700 rounded shadow-sm">
                                                {{ __('未查詢到任何個案') }}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        {{ $questions->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('ModalQuestionVisible')" wire:loading.attr="disabled">
                    {{ __('取消') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="question_save" wire:loading.attr="disabled">
                    {{ __('確定') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>

        <x-jet-dialog-modal wire:model="ModelDeleteVisible" maxWidth="2xl">
            <x-slot name="title">
                {{ __('刪除確認') }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                    <x-jet-label value="{{ __('確定要將此學生從課程中刪除嗎?') }}" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('ModelDeleteVisible')" wire:loading.attr="disabled">
                    {{ __('取消') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="leave_course" wire:loading.attr="disabled">
                    {{ __('確定') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>

        <x-jet-dialog-modal wire:model="ModelDeleteQuestionVisible" maxWidth="2xl">
            <x-slot name="title">
                {{ __('刪除確認') }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                    <x-jet-label value="{{ __('確定要將此個案移出課程嗎?') }}" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('ModelDeleteQuestionVisible')" wire:loading.attr="disabled">
                    {{ __('取消') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="unset_question" wire:loading.attr="disabled">
                    {{ __('確定') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
