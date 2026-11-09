@extends('layouts.app')

@section('content')

<div class="w-full">
    <h1 class="text-3xl font-bold text-teal-950 mt-1 mb-8">
        Tasks
    </h1>

    <div class="grid grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-3">
            @foreach($tasks as $task)
                <div class="bg-white border border-gray-200 rounded-2xl p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-teal-950">{{ $task->title }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $task->course->name }}</p>
                            <p class="text-sm text-gray-500 mt-1">Deadline: {{ $task->deadline->format('d.m.Y') }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $task->description }}</p>
                            <p class="text-sm text-gray-500 mt-1"><a href="{{ $task->link }}">Link to task</a></p>
                            
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit" title="{{ $task->is_completed ? 'Mark incomplete' : 'Mark completed'}}"
                                    class="w-5 h-5 rounded-full border border-teal-950 cursor-pointer mt-1 {{ $task->is_completed ? 'bg-teal-950' : 'bg-white' }}">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <form action="{{ route('tasks.store') }}" method="POST" class="bg-white border border-gray-200 rounded-2xl p-5">
            @csrf

            <h2 class="text-xl font-semibold text-teal-950 mb-5">
                Add task
            </h2>
            <div class="mb-4">
                <label class="block text-sm text-gray-500 mb-1">Title</label>

                <input type="text" name="title" class="w-full rounded-lg border border-gray-300 px-4 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-500 mb-1">Course</label>
                <select name="course_id" required 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2">

                    <option value="">Select course</option>

                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">
                            {{ $course->name }}
                        </option>
                    @endforeach
                
                
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-500 mb-1">Deadline</label>

                <input type="date" name="deadline" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-500 mb-1">Link</label>

                <input type="text" name="link" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-500 mb-1">Description</label>
                <textarea name="description" rows="2"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"></textarea>

            </div>

            <button type="submit" class="w-full bg-teal-950 text-white rounded-lg
                hover:bg-teal-900 transition cursor-pointer">
                Add task
            </button>

        </form>




    </div>

</div>

@endsection