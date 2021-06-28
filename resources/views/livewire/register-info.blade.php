<div>
    <div class="mt-4">
        <x-jet-label for="department_id" value="{{ __('選擇科系') }}" />
        <select wire:model="selectedDepartment" id="department_id" name="department_id"
            class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
            <option value="" selected>-- 選擇科系 --</option>
            @if ($departments->count())
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            @endif
        </select>
        @error('student_id') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="mt-4">
        <x-jet-label for="classes_id" value="{{ __('選擇班級') }}" />
        <select id="classes_id" name="classes_id" {{ $disabled }} class=" block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 round
            leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
            <option value="" selected>-- 選擇班級 --</option>
            @if (!is_null($selectedDepartment))
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            @endif
        </select>
        @error('classes_id') <span class="error">{{ $message }}</span> @enderror
    </div>
</div>
