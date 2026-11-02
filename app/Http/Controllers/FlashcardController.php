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
        $noteText = strip_tags($note->content); // removes HTML tags from note content

        $response = Http::timeout(120)->post( // Sends note content to API
        'http://127.0.0.1:11434/api/generate',
        [
            'model' => 'llama3.1:8b',

            'prompt' => "
                Create exactly 3 flashcards from this note.

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
        //
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
    public function show(Flashcard $flashcard)
    {
        //
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
