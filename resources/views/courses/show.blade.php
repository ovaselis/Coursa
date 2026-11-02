@extends('layouts.app')

@section('content')

<div class="w-full">
    <a href="{{ route('courses.index') }}" class="text-sm text-gray-500">
        Back to Courses
    </a>

    <div class="my-4 bg-white border border-gray-200 text-teal-950 rounded-2xl p-6">
        <div>
            <h1 class="text-3xl font-bold">{{ $course->name }}</h1>
            
            @if($course->lecturer)
                <p>Lecturer: {{ $course->lecturer }}</p>
            @endif

            

        </div>

        <div class="flex gap-2 mt-6">

            <a href="{{ route('courses.edit', $course) }}" 
                class="px-4 py-2 text-sm border border-teal-950
                           text-teal-950 rounded-lg
                           hover:bg-teal-950 hover:text-white transition"
                           title="Edit course">
                <i data-lucide="pencil" class="w-4 h-4"></i>
            </a>

            <form method="POST" action="{{ route('courses.destroy', $course) }}">

                @csrf
                @method('DELETE')

                <button type="submit" class="px-4 py-2 text-sm border border-teal-950
                           text-teal-950 rounded-lg
                           hover:bg-teal-950 hover:text-white transition cursor-pointer"
                           title="Delete course"
                    >
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                
                </button>
            </form>
        </div>

        @if($course->official_url)
            <div>

                <a href="{{ $course->official_url }}">Link to Course</a>

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
      
        @foreach($course->lectures as $lecture)           
            <div class="bg-white border border-gray-200 rounded-2xl p-5">
                <div class="mb-4"> 
                    <a href="{{ route('courses.lectures.show', [$course, $lecture]) }}">
                        <h1 class="text-2xl font-semibold text-teal-950">{{ $lecture->title }}</h1>
                    </a>
                </div>
                <div class="space-y-2">
                    @foreach($lecture->notes as $note)
                        <a href="{{ route('courses.lectures.notes.edit', [$course, $lecture, $note]) }}" class="block">
                            <div class="bg-gray-50 border border-gray-500 rounded-xl px-4 py-3 hover:bg-gray-100 transition">
                                <h3 class="font-semibold">
                                      {{ $note->title }}      
                                </h3>

                            </div>
                        </a>
                    @endforeach
                    
                    <a href="{{ route('courses.lectures.notes.edit', [$course, $lecture, $note]) }}" class="block">
                        <div class="bg-gray-50 border border-gray-500 rounded-xl px-4 py-3 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-mist-500">
                                + Add notes     
                            </h3>

                        </div>
                    </a>


                </div>

                
            </div>
        @endforeach
  
    </div>

</div>


@endsection
