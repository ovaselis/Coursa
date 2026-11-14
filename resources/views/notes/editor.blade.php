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
    @if($note)
        <div class="mt-10 border-t border-gray-200 pt-8"
            x-data="{ studying: false, current: 0, flipped: false, 
            cards: @js($note->flashcards->map(fn($card) => [
                'question' => $card->question,
                'answer' => $card->answer,
                ])->values()
            )
        }">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-2xl font-bold text-teal-950">Flashcards</h2>


                </div>

                <div class="flex items-center gap-3">
                    @if($note->flashcards->count() > 0)
                        <button type="button" class="mt-5 px-5 py-2.5 bg-teal-950 text-white
                            rounded-lg hover:bg-teal-900 transition cursor-pointer" 
                            @click="studying = true;
                            current = 0;
                            flipped = false;">Study</button>

                    @endif
                    <form method="POST" action="{{ route('flashcards.generate', $note) }}">
                        @csrf

                        <button
                            type="submit"
                            class="mt-5 px-5 py-2.5 bg-teal-950 text-white
                            rounded-lg hover:bg-teal-900 transition cursor-pointer">
                            {{ $note->flashcards->count() > 0 ? 'Regenerate' : 'Generate'}}
                        </button>
                    </form>
                </div>
            </div>
            @if($note->flashcards->count() > 0)
                <div class="space-y-3">
                    @foreach($note->flashcards as $flashcard)
                        <div>
                            <p class="font-semibold text-teal-950">{{ $flashcard->question }}</p>
                            <p class="text-gray-500 mt-2">{{ $flashcard->answer }}</p>
                        </div>
                    @endforeach


                </div>

            @else
                <div class="bg-white border border-gray-200 rounded-2xl p-6">
                    <p class="text-gray-500">No flashcards have been generated for this note yet.</p>
                </div>

            @endif

            {{-- Flashcard study screen--}}

            <div x-show="studying" x-cloak class="fixed inset-0 bg-gray-100 z-50 flex flex-col">
                <div class="bg-white border-b border-gray-200 px-8 py-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-teal-950">{{ $note->title }}</h2>
                    
                        <p class="text-sm text-gray-500 mt-1" x-text="(current + 1) + ' / ' + cards.length"></p>


                    </div>
                    <button type="button" @click="studying = false" class="text-sm text-gray-500 hover:text-teal-950 transition cursor-pointer">Close</button>
                </div>

                
                <div class="flex flex-1 items-center justify-center px-6 py-10">
                    <div @click="flipped = !flipped"
                        class="w-full max-w-2xl min-w-100 rounded-2xl shadow-sm hover:shadow-md transition bg-white border border-gray-200 flex items-center justify-center px-12 py-10 text-center cursor-pointer">
                        <div>
                        
                            <p x-show="!flipped" x-text="cards[current]?.question"
                                class="text-3xl font-bold text-teal-950 leading-relaxed"></p>
                            <p x-show="flipped" x-text="cards[current]?.answer"
                                class="text-3xl text-gray-700 leading-relaxed"></p>
                            <p class="text-sm text-gray-400 mt-8">
                                Click card to
                                <span x-show="!flipped">show answer</span>
                                <span x-show="flipped">show question</span>
                            </p>
                        </div> 
                    </div>
                </div>
            
                <div class="flex items-center justify-center gap-3 pb-10">
                    <button type="button" @click="
                        if(current > 0) {
                            current--;
                            flipped = false;
                        }"

                        :disabled="current === 0"
                        class="px-5 py-2.5 border border-teal-950 text-teal-950
                            rounded-lg hover:bg-teal-950 hover:text-white
                            transition cursor-pointer disabled:opacity-30 disabled:cursor-not-allowed"
                        >← Previous

                    </button>
                    <button type="button" @click="
                        if(current < cards.length - 1) {
                            current++;
                            flipped = false;
                        }"

                        :disabled="current === cards.length - 1"
                        class="px-5 py-2.5 border border-teal-950 text-teal-950
                            rounded-lg hover:bg-teal-950 hover:text-white
                            transition cursor-pointer disabled:opacity-30 disabled:cursor-not-allowed"

                        >Next →

                    </button>


                </div>


            </div>
        </div>
    @endif



</div>

@endsection