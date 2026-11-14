<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Note;

class FlashcardController extends Controller
{
    
    public function generate(Note $note)
    {
        abort_if($note->lecture->course->user_id !== auth()->id(), 403);

        $noteText = strip_tags($note->content); // removes HTML tags from note content

        $response = Http::timeout(120)->post( // Sends note content to API
        'http://127.0.0.1:11434/api/generate',
        [
            'model' => 'llama3.1:8b',

            'prompt' => "
                Create flashcards from the note.

                Generate as many flashcards as necessary to cover all important topics,
                concepts, definitions, facts, relationships and subtopics contained in the note.

                Return ONLY valid JSON in this format:
                {
                    \"flashcards\": [
                        {
                            \"question\": \"Question here\",
                            \"answer\": \"Answer here\"
                        }
                    ]
                }

                Note:
                {$noteText}
            ",

            'stream' => false, //waits for full response
            'format' => 'json', // json output
        ]
        );

        $data = json_decode(
            $response->json('response'),
            true
        );
        
        if(!isset($data['flashcards']) || !is_array($data['flashcards'])) { // checks if flashcards have been generated
            return back()->with('error', 'Dailded to generate flashcards.');
        }

        $note->flashcards()->delete();
        foreach ($data['flashcards'] as $card) {
            Flashcard::create([
                'note_id' => $note->id,
                'question' => $card['question'],
                'answer' => $card['answer'],
            ]);

        }
        return back()->with('success', 'Flashcards generated successfully.');

    }

    public function index()
    {
        $courses = auth()->user()->courses;

        return view('flashcards.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        abort_if($note->lecture->course->user_id !== auth()->id(), 403);

        $flashcards = $note->flashcards;

        return view('flashcards.show', compact('note', 'flashcards'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flashcard $flashcard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flashcard $flashcard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flashcard $flashcard)
    {
        //
    }
}
