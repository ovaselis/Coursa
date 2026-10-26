@extends('layouts.app')

@section('content')

<h1>Add note to {{ $lecture->title }}</h1>

<a href="{{ route('courses.lectures.show', [$course, $lecture]) }}">
    Back to lecture
</a>

<form method="POST" action="{{ route('courses.lectures.notes.store', [$course, $lecture]) }}">
    @csrf

    <div>
        <label for="title">Note title</label>
        <input
            type="text"
            name="title"
            id="title"
            value="{{ old('title') }}"
        >
    </div>

    <div>
        <label for="note-content">Content</label>
        
        <div class="mb-3 flex gap-2">
            
            <button type="button" id="bold-button">
                Bold
            </button>

            <button type="button" id="italic-button">
                Italic
            </button>

            <button type="button" id="h1-button">
                H1
            </button>

            <button type="button" id="bullet-list-button">
                List
            </button>

        </div>

        <div id="tiptap-editor" class="border"></div>
        <input 
            type="hidden"
            id="note-content"
            name="content"
            value="{{ old('content') }}">
         
    </div>

    <button type="submit">Save note</button>
</form>
@endsection