<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('使用者管理') }}
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
                    {{ __('新增使用者') }}
                </x-jet-button>
                <div class="flex flex-wrap py-6">
                    <table class="table-auto w-full text-left whitespace-no-wrap py-6 ">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100 rounded-tl rounded-bl">
                                    編號</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                    科系名稱</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                    班級名稱</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                    使用者名稱</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                    角色</th>
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
                                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ $item->id }}</td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">
                                            @if (!is_null($item->classes_id))
                                                {{ $item->classes->department->name }}
                                            @endif
                                        </td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">
                                            @if (!is_null($item->classes_id))
                                                {{ $item->classes->name }}
                                            @endif
                                        </td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ $item->name }}
                                        </td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ $item->role }}
                                        </td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">
                                            {{ $item->created_at->format('Y-m-d-H:i:s') }}</td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">
                                            {{ $item->updated_at->format('Y-m-d-H:i:s') }}</td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">
                                            <x-jet-button wire:click="UpdataShowModal({{ $item->id }})">
                                                {{ __('修改') }}
                                            </x-jet-button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="p-3 bg-gray-50 text-gray-700 rounded shadow-sm">
                                            {{ __('未查詢到任何使用者') }}
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    {{ $data->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                {{-- 表單 --}}
                <x-jet-dialog-modal wire:model="ModalFormVisible" maxWidth="2xl">
                    @if (empty($ModelId))
                        <x-slot name="title">
                            {{ __('新增使用者') }}
                        </x-slot>
                    @else
                        <x-slot name="title">
                            {{ __('修改使用者') }}
                        </x-slot>
                    @endif

                    <x-slot name="content">
                        @if(empty($ModelId))
                            <div class="mt-4">
                                <x-jet-label for="role" value="{{ __('角色') }}" />
                                <select id="role" wire:model="role" class=" block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 round
                                    leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="">-- 選擇角色 --</option>
                                    <option value="student">學生</option>
                                    <option value="teacher">老師</option>
                                    <option value="admin">管理者</option>
                                </select>
                                @error('role') <span class="error">{{ __('請選擇角色') }}</span> @enderror
                            </div>
                        @endif

                        <div class="mt-4" {{ $hidden }}>
                            <x-jet-label for="department_id" value="{{ __('選擇科系') }}" />
                            <select wire:model="selectedDepartment" id="department_id"
                                class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="">-- 選擇科系 --</option>
                                @if ($departments->count())
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('selectedDepartment') <span class="error">{{ __('請選擇科系') }}</span> @enderror
                        </div>

                        <div class="mt-4" {{ $hidden }}>
                            <x-jet-label for="classes_id" value="{{ __('選擇班級') }}" />
                            <select id="classes_id" wire:model="classes_id" {{ $disabled }} class=" block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 round
                                leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="">-- 選擇班級 --</option>
                                @if (!is_null($selectedDepartment))
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('classes_id') <span class="error">{{ __('請選擇班級') }}</span> @enderror
                        </div>

                        <div class="mt-4" {{ $hidden }}>
                            <x-jet-label for="student_id" value="{{ __('學號') }}" />
                            <x-jet-input id="student_id" class="block mt-1 w-full" type="text"
                                wire:model.debounce.500ms="student_id" />
                            @error('student_id') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="name" value="{{ __('使用者名稱') }}" />
                            <x-jet-input id="name" class="block mt-1 w-full" type="text"
                                wire:model.debounce.500ms="name" />
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="email" value="{{ __('電子郵件') }}" />
                            <x-jet-input id="email" class="block mt-1 w-full" type="email"
                                wire:model.debounce.500ms="email" />
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="account_number" value="{{ __('帳號') }}" />
                            <x-jet-input id="account_number" class="block mt-1 w-full" type="text"
                                wire:model.debounce.500ms="account_number" />
                            @error('account_number') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="password" value="{{ __('密碼') }}" />
                            <x-jet-input id="password" class="block mt-1 w-full" type="password"
                                wire:model.debounce.500ms="password" />
                            @error('password') <span class="error">{{ $message }}</span> @enderror
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
            </div>
        </div>
    </div>
</div>
