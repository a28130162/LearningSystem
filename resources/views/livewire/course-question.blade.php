<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$course_name}}{{ __('–課程個案') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12">
                <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                        <tr>
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                科目</th>
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                個案名稱</th>
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                            </th>
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->count())
                            @foreach ($data as $item)
                                <tr>
                                    <td class="border-t-2 border-gray-200 px-4 py-3">{{ $item->subject->name }}</td>
                                    <td class="border-t-2 border-gray-200 px-4 py-3">{{ $item->name }}</td>
                                    <td class="border-t-2 border-gray-200 px-4 py-3"></td>
                                    <td class="border-t-2 border-gray-200 px-4 py-3">
                                        <x-jet-button wire:click="ToQuiz({{ $item->id }})">
                                            {{ __('進行測驗') }}
                                        </x-jet-button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">{{ __('未查詢到任何課程個案') }}</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        {{ $data->links() }}
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
