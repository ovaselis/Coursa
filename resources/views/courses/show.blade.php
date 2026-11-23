@extends('layouts.app')

@section('content')

<div class="w-full">
    {{-- Return to course view--}}
    <a href="{{ route('courses.index') }}" class="text-sm text-gray-500">
        Back to Courses
    </a>
    {{-- Course information card --}}
    <div class="my-4 bg-white border border-gray-200 text-teal-950 rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold">{{ $course->name }}</h1>
            {{-- course edit page --}}
            <a href="{{ route('courses.edit', $course) }}" 
                class="text-teal-950 hover:text-teal-800 transition"
                           title="Edit course">
                <i data-lucide="pencil" class="w-4 h-4"></i> {{-- edit button symbol --}}
            </a>
        </div>     
      
        @if($course->lecturer)
            <p>Lecturer: {{ $course->lecturer }}</p>
        @endif
       

        @if($course->official_url)
            <div>

                <a href="{{ $course->official_url }}" class="text-sm text-teal-950 hover:text-teal-800">Link to Course</a>

            </div>
        @endif

        @if($course->info)
            <div>
                <p class="text-sm text-gray-500">Information:</p>
                <p>{{ $course->info }}</p>
            </div>      
        @endif

    </div>
   
    <div class="space-y-5">        
        {{-- Shows all lectures connected to the course --}}
        @forelse($course->lectures as $lecture)           
            <div class="bg-white border border-gray-200 rounded-2xl p-5">
                <div class="mb-4">
                    <div class="flex items-start justify-between"> 
                        {{-- Opens selected lecture --}}
                        <a href="{{ route('courses.lectures.show', [$course, $lecture]) }}">
                            <h2 class="text-2xl font-semibold text-teal-950">{{ $lecture->title }}</h2>
                        </a>
                        {{-- Opens selected lecture edit --}}
                        <a href="{{ route('courses.lectures.edit', [$course, $lecture]) }}"
                            class="text-teal-950 hover:text-teal-800 transition" title="Edit lecture">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                    </div>
                    <div>
                        @if($lecture->date)
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $lecture->date }}
                            </p>
                        @endif

                        @if($lecture->info)
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $lecture->info }}
                            </p>
                        @endif
                       
                    </div>
                </div>
                <div class="space-y-2">
                    {{-- Displays all notes connected to the lecture --}}
                    @foreach($lecture->notes as $note)
                        {{-- Opens the selected notes edit --}}
                        <a href="{{ route('courses.lectures.notes.edit', [$course, $lecture, $note]) }}" class="block">
                            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 hover:bg-gray-100 transition">
                                <h3 class="font-semibold">
                                      {{ $note->title }}      
                                </h3>

                            </div>
                        </a>
                    @endforeach
                    {{-- Openjs new note create --}}
                    <a href="{{ route('courses.lectures.notes.create', [$course, $lecture]) }}" class="block">
                        <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-gray-500">
                                + Add notes     
                            </h3>

                        </div>
                    </a>


                </div>

                
            </div>
            {{-- Displayed if course doesnt have any lectures --}}
            @empty

            <div class="bg-white border border-gray-200 rounded-2xl p-5"> 
                <p class="text-gray-500">No lectures yet</p>
            </div>

                 

        @endforelse
        {{-- Opens form for creating a new lecture --}}
        <a href="{{ route('courses.lectures.create', $course) }}" class="block">
            <div class="bg-white border border-gray-200 rounded-xl px-4 py-3 hover:bg-gray-50 transition">
                <h3 class="font-semibold text-gray-500">
                    + Add lecture    
                </h3>

            </div>
        </a>   

    </div>

</div>


@endsection
