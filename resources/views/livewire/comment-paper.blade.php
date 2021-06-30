<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('評論試卷管理') }}
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
                    {{ __('新增評論試卷') }}
                </x-jet-button>
                <div class="flex flex-wrap py-6">
                    <table class="table-auto w-full text-left whitespace-no-wrap py-6 ">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100 rounded-tl rounded-bl">
                                    試卷名稱</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                    創建日期</th>
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
                                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ $item->name }}</td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ $item->created_at }}</td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ $item->updated_at }}</td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">
                                            <x-jet-button wire:click="comment_paper_preview({{ $item->id }})">
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
                                    <td colspan="4">
                                        <div class="p-3 bg-gray-50 text-gray-700 rounded shadow-sm">
                                            {{ __('未查詢到任何試卷') }}
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
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
                            {{ __('建立評論試卷') }}
                        </x-slot>
                    @else
                        <x-slot name="title">
                            {{ __('修改評論試卷') }}
                        </x-slot>
                    @endif

                    <x-slot name="content">
                        <div class="mt-4">
                            <x-jet-label for="name" value="{{ __('試卷名稱') }}" />
                            <x-jet-input id="name" class="block mt-1 w-full" type="text"
                                wire:model.debounce.500ms="name" />
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="description" value="{{ __('評分規準') }}" />
                            <x-jet-input id="description" class="block mt-1 w-full" type="text"
                                wire:model.debounce.500ms="description" />
                            @error('description') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="comment_project" value="{{ __('評論項目') }}" />
                            @foreach ($comment_projects as $index => $comment_project)
                                <div class="py-2 w-full border border-gray-200">
                                    <div
                                        class="h-full p-6 mt-1 w-full rounded-md shadow-sm bg-gray-50 border-gray-300 flex flex-col relative overflow-hidden">
                                        @if (empty($comment_paper_id) && count($comment_projects) > 1)
                                            <button wire:click="removeCommentProject({{ $index }})">
                                                <span
                                                    class="bg-red-500 text-white px-4 py-2 tracking-widest text-xs absolute right-0 top-0 rounded-bl">刪除</span>
                                            </button>
                                        @endif
                                        <div class="mt-2">
                                            <x-jet-label for="comment_projects.{{ $index }}.name"
                                                value="{{ __('項目名稱') }}" />
                                            <x-jet-input id="comment_projects.{{ $index }}.name"
                                                class="block mt-1 w-full" type="text"
                                                wire:model.defer="comment_projects.{{ $index }}.name" />
                                            @error('comment_projects.' . $index . '.name') <span
                                                class="error">{{ $message }}</span> @enderror
                                        </div>
                                        @foreach ($comment_projects[$index]['project_contents'] as $index2 => $project_content)
                                            <div
                                                class="h-full p-6 mt-1 w-full rounded-md shadow-sm bg-gray-50 border-gray-300 flex flex-col relative overflow-hidden">
                                                @if (empty($comment_paper_id) && count($comment_projects[$index]['project_contents']) > 1)
                                                    <button
                                                        wire:click="removeProjectContent({{ $index }},{{ $index2 }})">
                                                        <span
                                                            class="bg-red-500 text-white px-4 py-2 tracking-widest text-xs absolute right-0 top-0 rounded-bl">刪除</span>
                                                    </button>
                                                @endif
                                                <div class="mt-1">
                                                    <x-jet-label
                                                        for="comment_projects.{{ $index }}.project_contents.{{ $index2 }}.dimension"
                                                        value="{{ __('表現向度') }}" />
                                                    <textarea
                                                        id="comment_projects.{{ $index }}.project_contents.{{ $index2 }}.dimension"
                                                        wire:model.defer="comment_projects.{{ $index }}.project_contents.{{ $index2 }}.dimension"
                                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                                                    @error('comment_projects.' . $index . '.project_contents.' . $index2
                                                        . '.dimension')
                                                    <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="mt-1">
                                                    <x-jet-label
                                                        for="comment_projects.{{ $index }}.project_contents.{{ $index2 }}.level_content"
                                                        value="{{ __('表現等級內容') }}" />
                                                    <textarea rows="4"
                                                        id="comment_projects.{{ $index }}.project_contents.{{ $index2 }}.level_content"
                                                        wire:model.defer="comment_projects.{{ $index }}.project_contents.{{ $index2 }}.level_content"
                                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                                                    @error('comment_projects.' . $index . '.project_contents.' . $index2
                                                        . '.level_content')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endforeach
                                        @if (empty($comment_paper_id))
                                            <x-jet-button class="my-4"
                                                wire:click="addProjectContent({{ $index }})"
                                                wire:loading.attr="disabled">
                                                {{ __('新增項目內容') }}
                                            </x-jet-button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            @if (empty($comment_paper_id))
                                <x-jet-button class="my-4" wire:click="addCommentProject" wire:loading.attr="disabled">
                                    {{ __('新增評論項目') }}
                                </x-jet-button>
                            @endif
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-secondary-button wire:click="$toggle('ModalFormVisible')" wire:loading.attr="disabled">
                            {{ __('取消') }}
                        </x-jet-secondary-button>

                        @if (empty($comment_paper_id))
                            <x-jet-button class="ml-2" wire:click="Create" wire:loading.attr="disabled">
                                {{ __('建立試卷') }}
                            </x-jet-button>
                        @else
                            <x-jet-button class="ml-2" wire:click="Updata" wire:loading.attr="disabled">
                                {{ __('修改試卷') }}
                            </x-jet-button>
                        @endif

                    </x-slot>
                </x-jet-dialog-modal>

                @if($data->count())
                <x-jet-dialog-modal wire:model="ModalPreviewVisible">
                    <x-slot name="title">
                            {{ __('預覽評論試卷') }}
                        </x-slot>

                        <x-slot name="content">
                        <div class="mt-4">
                            <div class="text-xl text-gray-600 leading-7 font-semibold">
                                <p>評論試卷名稱：{{ $name }}</p>
                                <br>
                                <p>評分規準：{{ $description }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="mt-4 border-b-2 border-gray-200 text-xl text-gray-600 leading-7 font-semibold">
                                {{ __('問題評估') }}
                            </div>
                            @foreach ($comment_projects as $index => $comment_project)
                                <div class="ml-2">
                                    <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                        {{ $comment_projects[$index]['name'] }}
                                    </div>
                                    @foreach ($comment_projects[$index]['project_contents'] as $index2 => $project_content)
                                        <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                            <p>{{ $comment_projects[$index]['project_contents'][$index2]['dimension'] }}</p>
                                        </div>
                                        <div class="mt-2 border border-gray-300">
                                            <div class="ml-2 mt-2 text-lg text-gray-600 leading-7 font-semibold">
                                                <p>{{__('表現等級內容：')}}</p>
                                            </div>
                                            <textarea disabled rows="4" style="resize:none;"
                                            class="block mb-2 mt-1 w-full border-none">{{ $comment_projects[$index]['project_contents'][$index2]['level_content'] }}</textarea>
                                        </div>
                                        <div class="mt-2 text-lg text-gray-600">
                                            <p>{{__('評論分數：')}}</p>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="comments.{{$index}}.{{$index2}}.score" value="1">
                                                <span class="ml-2">1級</span>
                                            </label>
                                            <label class="inline-flex items-center ml-6">
                                                <input type="radio" name="comments.{{$index}}.{{$index2}}.score" value="2">
                                                <span class="ml-2">2級</span>
                                            </label>
                                            <label class="inline-flex items-center ml-6">
                                                <input type="radio" name="comments.{{$index}}.{{$index2}}.score" value="3">
                                                <span class="ml-2">3級</span>
                                            </label>
                                            <label class="inline-flex items-center ml-6">
                                                <input type="radio" name="comments.{{$index}}.{{$index2}}.score" value="4">
                                                <span class="ml-2">4級</span>
                                            </label>
                                            <div class="mt-2 text-lg text-gray-600 leading-7 font-semibold">
                                                <p>{{__('備註：')}}</p>
                                            </div>
                                            <textarea
                                            class="block mb-2 mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            <div class="ml-2">
                                <div class="mt-4 text-lg text-gray-600 leading-7 font-semibold">
                                    {{ __('補充說明') }}
                                    <textarea
                                    class="block mb-2 mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-secondary-button wire:click="$toggle('ModalPreviewVisible')" wire:loading.attr="disabled">
                            {{ __('關閉') }}
                        </x-jet-secondary-button>
                    </x-slot>
                </x-jet-dialog-modal>
                @endif
            </div>
        </div>
    </div>
</div>
