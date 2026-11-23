@extends('layouts.app')

@section('content')

<div class="w-full">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-teal-950">
            Edit task
        </h1>

    </div>
    <div class="bg-white border border-gray-200 rounded-2xl p-6">
        {{-- Update form for task--}}
        <form action="{{ route('tasks.update', $task) }}" id="task-form" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                    Title
                </label>
                <input required class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900"
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $task->title) }}"
                >
            </div>

            <div>
                <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Course
                </label>
                <select required class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900"
                    name="course_id"
                    id="course_id">
                    @foreach($courses as $course)
                        <option
                            value="{{ $course->id }}"
                            @if($task->course_id == $course->id) selected @endif
                        >
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>

            </div>
            <div>
                <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">
                    Deadline
                </label>
                <input required class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900"
                    type="date"
                    name="deadline"
                    id="deadline"
                    value="{{ old('deadline', $task->deadline->format('Y-m-d')) }}"
                >

            </div>
            <div>
                <label for="link" class="block text-sm font-medium text-gray-700 mb-1">
                    Link
                </label>
                <input class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900"
                    type="text"
                    name="link"
                    id="link"
                    value="{{ old('link', $task->link) }}"
                >

            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Description
                </label>
                <textarea class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900"
                    name="description"
                    id="description"
                    rows="3"
                    
                >{{ old('description', $task->description) }}</textarea>
            </div>
        </form>
        <div class="flex items-center gap-3 mt-3">
            {{-- Update forms submit --}}
            <button type="submit" form="task-form" class="h-11 px-5 bg-teal-950 text-white rounded-lg hover:bg-teal-900 transition cursor-pointer">
                Save changes
            </button>
            {{-- Delete --}}
            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Do you really want to delete this task?')">
                @csrf
                @method('DELETE')

                <button title="Delete task" type="submit" class="h-11 w-11 flex items-center justify-center bg-red-800 text-white rounded-lg hover:bg-red-700 transition cursor-pointer">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>


            </form>

        </div>

    </div>


</div>
@endsection