@extends('layouts.app')

@section('content')

<div class="w-full">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-teal-950">Edit course</h1>
    </div>
    
    <div class="bg-white border border-gray-200 rounded-2xl p-6">

        <form method="POST" action="{{ route('courses.update', $course) }}">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Course name
                </label>

                <input type="text" name="name" id="name" value="{{ old('name', $course->name) }}"
                    class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2
                        focus:border-teal-900 focus:ring-teal-900"
                >
            </div>

            <div>
                <label for="official_url" class="block text-sm font-medium text-gray-700 mb-1">
                    Course official page
                </label>

                <input type="url" name="official_url" id="official_url" value="{{ old('official_url', $course->official_url) }}"
                    class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2
                        focus:border-teal-900 focus:ring-teal-900"
                >
            </div>
            
            <div>
                <label for="lecturer" class="block text-sm font-medium text-gray-700 mb-1">
                    Lecturer
                </label>

                <input type="text" name="lecturer" id="lecturer" value="{{ old('lecturer', $course->lecturer) }}"
                    class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2
                        focus:border-teal-900 focus:ring-teal-900"
                >
            </div>

            <div>
                <label for="info" class="block text-sm font-medium text-gray-700 mb-1">
                    Additional info
                </label>

                <textarea name="info" id="info" rows="5"
                    class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2
                        focus:border-teal-900 focus:ring-teal-900"
                    >{{ old('info', $course->info) }}
                </textarea>
            </div>

            <button
                type="submit"
                class="mt-3 px-5 py-2.5 bg-teal-950 text-white rounded-lg hover:bg-teal-900 transition cursor-pointer"
            >
                Save changes
            </button>

        </form>

        <form method="POST" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('Do you want to delete this course?')" class="mt-3">
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