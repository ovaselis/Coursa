@extends('layouts.app')

@section('content')


<div class="w-full">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-teal-950">Edit lecture</h1>
    </div>
    <div class="bg-white border border-gray-200 rounded-2xl p-6">
        <form method="POST" action="{{ route('courses.lectures.update', [$course, $lecture]) }}">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Lecture title</label>
                <input required class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900"
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $lecture->title) }}"
                >
            </div>

            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900"
                    type="date"
                    name="date"
                    id="date"
                    value="{{ old('date', $lecture->date) }}"
                >
            </div>

            <div>
                <label for="info" class="block text-sm font-medium text-gray-700 mb-1">Additional info</label>
                <textarea name="info" id="info" rows="3" class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900">{{ old('info', $lecture->info) }}</textarea>
            </div>

            <button class="mt-3 px-5 py-2.5 bg-teal-950 text-white rounded-lg hover:bg-teal-900 transition cursor-pointer" type="submit">Save lecture</button>



        </form>

        <form method="POST" action="{{ route('courses.lectures.destroy', [$course, $lecture]) }}" onsubmit="return confirm('Do you want to delete this lecture?')" class="mt-3">
            @csrf
            @method('DELETE')

            <button type="submit" class="p-2.5 bg-red-800 text-white rounded-lg
                    hover:bg-red-700 transition cursor-pointer"title="Delete course"
                >
                <i data-lucide="trash-2" class="w-4 h-4"></i>
            </button>
        </form>

    </div>
</div>
@endsection