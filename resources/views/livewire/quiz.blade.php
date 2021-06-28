<div>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('進行測驗') }}
            </h2>
            <div id="clockdiv" class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('剩餘時間：') }}
                </h2>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <span class="hours">
                        @if ($quiz_time > 60)
                            {{ str_pad(floor($quiz_time / 60), 2, '0', STR_PAD_LEFT) }}
                        @else
                            {{ __('00') }}
                        @endif
                    </span>
                    <span>{{ __('小時') }}</span>
                    <span class="minutes">
                        @if ($quiz_time > 60)
                            {{ str_pad($quiz_time % 60, 2, '0', STR_PAD_LEFT) }}
                        @else
                            {{ str_pad($quiz_time, 2, '0', STR_PAD_LEFT) }}
                        @endif
                    </span>
                    <span>{{ __('分') }}</span>
                    <span class="seconds">
                        {{ __('00') }}
                    </span>
                    <span>{{ __('秒') }}</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if ($start_quiz)
                        <div class="p-6 border-gray-200">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-700" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <div class="ml-4 text-2xl text-gray-600 leading-7 font-semibold">
                                    開始測驗
                                </div>
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
                            @foreach ($data->case_informations as $case_information)
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
                                                <iframe
                                                    src="https://www.youtube.com/embed/{{ $case_information->video }}"
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
                                @foreach ($data->case_informations as $index => $case_information)
                                    <div class="ml-2">
                                        <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                            {{ __('資料來源：') . $case_information->title }}
                                        </div>
                                        @foreach ($data->problem_assessments as $index2 => $problem_assessment)
                                            <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                                {{ $problem_assessment->title }}
                                            </div>
                                            <div class="mt-2 text-lg text-gray-600">
                                                {{ $problem_assessment->content }}
                                            </div>
                                            <textarea
                                                id="problem_assessment_answers.{{ $index }}.{{ $index2 }}.content"
                                                wire:model="problem_assessment_answers.{{ $index }}.{{ $index2 }}.content"
                                                class="block mb-2 mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
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
                                    @foreach ($data->problem_solveds as $index => $problem_solved)
                                        <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                            {{ $problem_solved->title }}
                                        </div>
                                        <div class="mt-2 text-lg text-gray-600">
                                            {{ $problem_solved->content }}
                                        </div>
                                        <textarea id="problem_solved_answers.{{ $index }}.content"
                                            wire:model="problem_solved_answers.{{ $index }}.content"
                                            class="block mb-2 mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex">
                            <x-jet-button class="mt-4  m-auto text-xl" wire:click='end_check'>
                                {{ __('交卷') }}
                            </x-jet-button>
                        </div>
                    @else
                        <div class="p-6 border-gray-200">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-700" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="ml-4 text-2xl text-gray-600 leading-7 font-semibold">
                                    歡迎使用線上作答功能，此頁為個案資訊
                                </div>
                            </div>
                        </div>

                        <div class="pl-16 pb-4 border-gray-200">
                            <div class="ml-4 text-2xl text-gray-600 leading-7 font-semibold">
                                <p>個案名稱：{{ $data->name }}<span class="ml-10">作答時間：{{ $data->quiz_time }}分鐘</span>
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

                            @foreach ($data->question_descriptions as $question_description)
                                <div class="ml-16">
                                    <div class="mt-4 text-xl text-gray-600 leading-7 font-semibold">
                                        {{ $question_description->title }}
                                    </div>
                                    <div class="mt-2 text-xl text-gray-600">
                                        {{ $question_description->content }}
                                    </div>
                                </div>
                            @endforeach
                            <div class="flex">
                                <x-jet-button class="mt-4  m-auto text-xl" wire:click='start'>
                                    {{ __('開始測驗') }}
                                </x-jet-button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-jet-dialog-modal wire:model="end_check_model" maxWidth="2xl">
        <x-slot name="title">
            {{ __('結束測驗') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <div class="ml-4 text-2xl text-gray-600 leading-7 font-semibold">
                    確定要結束測驗嗎?<br>
                    請確認已填寫完所有資料
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('end_check_model')" wire:loading.attr="disabled">
                {{ __('取消') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="end" wire:loading.attr="disabled">
                {{ __('確定') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
<script>
    window.addEventListener('start_quiz', event => {
        const deadline = new Date(Date.parse(new Date()) + @this.quiz_time * 60 * 1000);
        initializeClock('clockdiv', deadline);
    })

    window.addEventListener('end_quiz', event => {
        clearInterval(timeinterval);
    })

    function getTimeRemaining(endtime) {
        const total = Date.parse(endtime) - Date.parse(new Date());
        const seconds = Math.floor((total / 1000) % 60);
        const minutes = Math.floor((total / 1000 / 60) % 60);
        const hours = Math.floor(total / (1000 * 60 * 60));
        return {
            total,
            hours,
            minutes,
            seconds
        };
    }

    function initializeClock(id, endtime) {
        const clock = document.getElementById(id);
        const hoursSpan = clock.querySelector('.hours');
        const minutesSpan = clock.querySelector('.minutes');
        const secondsSpan = clock.querySelector('.seconds');

        function updateClock() {
            const t = getTimeRemaining(endtime);
            hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
            minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
            secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
            if (t.total <= 0) {
                clearInterval(timeinterval);
                @this.end();
                alert('測驗時間已結束!');
            }
        }
        updateClock();
        const timeinterval = setInterval(updateClock, 1000);
    }
</script>
</div>
