@extends('layouts.app')

@section('content')

<div class="w-full">
    <a href="{{ route('courses.show', $course) }}" class="text-sm text-gray-500">Back to Course</a>

    <form method="POST" action="{{
        $note ? route('courses.lectures.notes.update', [$course, $lecture, $note])
        : route('courses.lectures.notes.store', [$course, $lecture])
    }}">

        @csrf
    
        @if($note)
            @method('PUT')
        @endif
        
        <input type="text" name="title" value="{{ old('title', $note?->title) }}"
            class="w-full text-3xl font-bold text-teal-950 border border-gray-300 rounded-xl px-4 py-3 mb-5">

        <x-editor :content="old('content', $note?->content)" />

        <button type="submit" class="mt-5 px-5 py-2.5 bg-teal-950 text-white
                   rounded-lg hover:bg-teal-900 transition cursor-pointer">
            Save note
        </button>


    </form>



</div>

@endsection