<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('管理列表') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="flex flex-wrap -m-4 text-center p-5">
                    <button class="p-4 md:w-1/4 sm:w-1/2 w-full" wire:click="toDepartment">
                        <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-indigo-500 w-12 h-12 mb-3 inline-block"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                            <h2 class="title-font font-medium text-3xl text-gray-900">科系管理</h2>
                        </div>
                    </button>
                    <button class="p-4 md:w-1/4 sm:w-1/2 w-full" wire:click="toClasses">
                        <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" class="text-indigo-500 w-12 h-12 mb-3 inline-block"
                                viewBox="0 0 24 24">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"></path>
                            </svg>
                            <h2 class="title-font font-medium text-3xl text-gray-900">班級管理</h2>
                        </div>
                    </button>
                    <button class="p-4 md:w-1/4 sm:w-1/2 w-full" wire:click='toCourse'>
                        <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-indigo-500 w-12 h-12 mb-3 inline-block"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                            <h2 class="title-font font-medium text-3xl text-gray-900">課程管理</h2>
                        </div>
                    </button>
                    <button class="p-4 md:w-1/4 sm:w-1/2 w-full" wire:click='toUser'>
                        <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-indigo-500 w-12 h-12 mb-3 inline-block"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h2 class="title-font font-medium text-3xl text-gray-900">使用者管理</h2>
                        </div>
                    </button>
                    <button class="p-4 md:w-1/4 sm:w-1/2 w-full" wire:click='toSubject'>
                        <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-indigo-500 w-12 h-12 mb-3 inline-block"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h2 class="title-font font-medium text-3xl text-gray-900">科目管理</h2>
                        </div>
                    </button>
                    <button class="p-4 md:w-1/4 sm:w-1/2 w-full" wire:click='toQuestion'>
                        <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-indigo-500 w-12 h-12 mb-3 inline-block"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h2 class="title-font font-medium text-3xl text-gray-900">個案管理</h2>
                        </div>
                    </button>
                    <button class="p-4 md:w-1/4 sm:w-1/2 w-full" wire:click='toCommentPaper'>
                        <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-indigo-500 w-12 h-12 mb-3 inline-block"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <h2 class="title-font font-medium text-3xl text-gray-900">評論試卷管理</h2>
                        </div>
                    </button>
                    <button class="p-4 md:w-1/4 sm:w-1/2 w-full" wire:click='toRecord'>
                        <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-indigo-500 w-12 h-12 mb-3 inline-block"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            <h2 class="title-font font-medium text-3xl text-gray-900">作答紀錄管理</h2>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
