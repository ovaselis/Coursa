@extends('layouts.app')

@section('content')

<div class="w-full">

    <div class="items-center justify-between w-full mb-4">

        <h1 class="text-3xl font-bold text-teal-950 mb-4"> Courses </h1>

        <a
            href="{{ route('courses.create') }}"
            class="mt-3 text-sm font-medium text-teal-950
                   border border-teal-950 px-4 py-2 rounded-lg
                   hover:bg-teal-950 hover:text-white transition"
        >
            + Add course
        </a>

    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">


        @foreach($courses as $course)
            <a href="{{ route('courses.show', $course) }}" class="block">
                <div class="min-h-40 bg-white border border-gray-200 rounded-2xl p-6 flex flex-col hover:shadow-md transition">

                    <h2 class="text-xl font-bold text-teal-950">{{ $course->name }}</h2>
                    <p class="text-gray-500">{{ $course->lecturer }}</p>

                </div>
            </a>
        @endforeach

        
    </div>
</div>

@endsection
