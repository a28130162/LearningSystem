<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('成績列表') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                    <div class="mt-4">
                        <div class="mb-4 text-xl text-gray-600 leading-7 font-semibold">
                            選擇課程
                        </div>
                        <select id="course" wire:model="selected_course" class=" block appearance-none w-auto bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 round
                        leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="">-- 選擇課程 --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="flex flex-wrap py-6">
                    <table class="table-auto w-full text-left whitespace-no-wrap py-6 ">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100 rounded-tl rounded-bl">
                                    科目</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100 rounded-tl rounded-bl">
                                    個案名稱</th>
                                @if(Auth::user()->role=='teacher'||Auth::user()->role=='admin')
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                        學號</th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                        學生姓名</th>
                                @endif
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                    測驗日期</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                    評論狀態</th>
                                <th
                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-md bg-gray-100">
                                    作答/評論內容</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data->count())
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">
                                            {{ $item->question->subject->name }}
                                        </td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ $item->question->name }}</td>
                                        @if(Auth::user()->role=='teacher'||Auth::user()->role=='admin')
                                            <td class="border-t-2 border-gray-200 px-4 py-3">
                                                {{ $item->user->student_id }}
                                            </td>
                                            <td class="border-t-2 border-gray-200 px-4 py-3">
                                                {{ $item->user->name }}
                                            </td>
                                        @endif
                                        <td class="border-t-2 border-gray-200 px-4 py-3">
                                            {{ $item->created_at }}
                                        </td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">
                                            @if($item->comments->where('user_id',$item->user_id)->count() == 0)
                                            <span
                                                class="px-2 inline-flex text-md leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-500">
                                                學生未評論
                                            </span>
                                            @else
                                            <span
                                                class="px-2 inline-flex text-md leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-500">
                                                學生已評論
                                            </span>
                                            @endif
                                            @if ($item->comments->where('user_id','<>',$item->user_id)->count() == 0)
                                            <span
                                                class="px-2 inline-flex text-md leading-5 font-semibold rounded-full bg-green-100 text-green-500">
                                                老師未評論
                                            </span>
                                            @else
                                            <span
                                                class="px-2 inline-flex text-md leading-5 font-semibold rounded-full bg-green-100 text-green-500">
                                                老師已評論
                                            </span>
                                            @endif
                                        </td>
                                        <td class="border-t-2 border-gray-200 px-4 py-3">
                                            <x-jet-button wire:click="answer_content({{ $item->id }})">
                                                {{ __('查看作答內容') }}
                                            </x-jet-button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        @if ($selected_course == null)
                                            <div class="p-3 bg-gray-50 text-gray-700 rounded shadow-sm">
                                                {{ __('請選擇課程') }}
                                            </div>
                                        @else
                                            <div class="p-3 bg-gray-50 text-gray-700 rounded shadow-sm">
                                                {{ __('未查詢到任何作答紀錄') }}
                                            </div>
                                        @endif
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
            </div>
        </div>
    </div>
</div>
