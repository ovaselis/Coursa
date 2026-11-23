@extends('layouts.app')

@section('content')

<div class="w-full">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-teal-950">Add a course</h1>
    </div>
    
    <div class="bg-white border border-gray-200 rounded-2xl p-6">

        <form method="POST" action="{{ route('courses.store') }}">
            @csrf

            <div>
                <label for="name" required class="block text-sm font-medium text-gray-700 mb-1">Course name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900">
            </div>

            <div>
                <label for="official_url" class="block text-sm font-medium text-gray-700 mb-1">Course official page</label>
                <input type="url" name="official_url" id="official_url" value="{{ old('official_url') }}" class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900">
            </div>
            
            <div>
                <label for="lecturer" class="block text-sm font-medium text-gray-700 mb-1">Lecturer</label>
                <input type="text" name="lecturer" id="lecturer" value="{{ old('lecturer') }}" class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900">
            </div>

            <div>
                <label for="info" class="block text-sm font-medium text-gray-700 mb-1">Additional info</label>
                <textarea name="info" id="info" rows="5" class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2 focus:border-teal-900 focus:ring-teal-900">{{ old('info') }}</textarea>
            </div>

            <button class="mt-3 px-5 py-2.5 bg-teal-950 text-white rounded-lg hover:bg-teal-900 transition cursor-pointer" type="submit">Save course</button>


        </form>
    </div>
</div>

@endsection
