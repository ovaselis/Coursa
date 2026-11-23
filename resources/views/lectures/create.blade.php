@extends('layouts.app')

@section('content')


<div class="w-full">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-teal-950">Add lecture to {{ $course->name }}</h1>
    </div>
    <div class="bg-white border border-gray-200 rounded-2xl p-6">
        {{-- New lecture form --}}
        <form method="POST" action="{{ route('courses.lectures.store', $course) }}">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Lecture title</label>
                <input required class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900"
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title') }}"
                >
            </div>

            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900"
                    type="date"
                    name="date"
                    id="date"
                    value="{{ old('date') }}"
                >
            </div>

            <div>
                <label for="info" class="block text-sm font-medium text-gray-700 mb-1">Additional info</label>
                <textarea name="info" id="info" rows="3" class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900">{{ old('info') }}</textarea>
            </div>

            <button class="mt-3 px-5 py-2.5 bg-teal-950 text-white rounded-lg hover:bg-teal-900 transition cursor-pointer" type="submit">Save lecture</button>



        </form>
    </div>
</div>
@endsection