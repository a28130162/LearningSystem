<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('課程列表') }}
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
                @if (Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                    <x-jet-button wire:click="CreateShowModal">
                        {{ __('創建課程') }}
                    </x-jet-button>
                @endif
                <div class="flex flex-wrap -m-2 py-6">
                    @if ($data->count())
                        @foreach ($data as $item)
                            <div class="p-2 lg:w-1/3 md:w-1/2 w-full">
                                <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg">
                                    {{-- <img alt="team"
                                        class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                        src="https://dummyimage.com/80x80"> --}}
                                    <div class="flex-grow">
                                        <h2 class="text-gray-900 title-font font-medium">課程名稱：{{ $item->name }}</h2>
                                        <p class="text-gray-500">指導老師：{{ $item->user->name }}老師</p>
                                    </div>
                                    @if (Auth::user()->role == 'student')
                                        <x-jet-button wire:click="ToCourseQuestion({{ $item->id }})">
                                            {{ __('進入課程') }}
                                        </x-jet-button>
                                    @else
                                        <x-jet-button wire:click="ToEdit({{ $item->id }})">
                                            {{ __('管理課程') }}
                                        </x-jet-button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-3 w-full bg-gray-50 text-gray-700 rounded shadow-sm">
                            {{ __('未查詢到任何課程') }}
                        </div>
                    @endif

                </div>
                <br />
                {{ $data->links() }}

                {{-- 創建表單 --}}
                @if (Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                    <x-jet-dialog-modal wire:model="ModalFormVisible" maxWidth="2xl">
                        <x-slot name="title">
                            {{ __('創建課程') }}
                        </x-slot>

                        <x-slot name="content">
                            @if (Auth::user()->role == 'admin')
                                <div class="mt-4">
                                    <x-jet-label for="user_id" value="{{ __('選擇老師') }}" />
                                    <select wire:model="user_id" id="user_id"
                                        class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="">-- 選擇老師 --</option>
                                        @if ($teachers->count())
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            @endif
                            <div class="mt-4">
                                <x-jet-label for="name" value="{{ __('課程名稱') }}" />
                                <x-jet-input id="name" class="block mt-1 w-full" type="text"
                                    wire:model.debounce.800ms="name" />
                                @error('name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <x-jet-secondary-button wire:click="$toggle('ModalFormVisible')"
                                wire:loading.attr="disabled">
                                {{ __('取消') }}
                            </x-jet-secondary-button>

                            <x-jet-button class="ml-2" wire:click="Create" wire:loading.attr="disabled">
                                {{ __('創建') }}
                            </x-jet-button>
                        </x-slot>
                    </x-jet-dialog-modal>
                @endif
            </div>
        </div>
    </div>
</div>
