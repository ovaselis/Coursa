@extends('layouts.app')

@section('content')

<div class="w-full">
    <div class="flex items-center justify-between w-full mb-4">
        <div>
            <h1 class='text-2xl font-bold text-teal-950'>Flashcards</h1>
            <p class="text-gray-500">{{ $note->title }}</p>
        </div>

        <form method="POST" action="{{ route('flashcards.generate', $note) }}">
            @csrf

            <button
                type="submit"
                class="mt-5 px-5 py-2.5 bg-teal-950 text-white
                   rounded-lg hover:bg-teal-900 transition cursor-pointer">
                {{ $note->flashcards->count() > 0 ? 'Regenarate' : 'Generate'}}
            </button>
        </form>
    </div>
    @if($flashcards->count() > 0)
        <div class="space-y-3">
            @foreach($note->flashcards as $flashcard)
                <div>
                    <p class="font-semibold text-teal-950">{{ $flashcard->question }}</p>
                    <p class="text-gray-500 mt-2">{{ $flashcard->answer }}</p>
                </div>
            @endforeach


        </div>

</div>

@endsection