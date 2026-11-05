<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class NoteController extends Controller
{
    public function index()
    {
        return Inertia::render('Notes/index', [
            'notes' => Note::all(),
        ]);
    }

    public function create(ResponseFactory $inertia): Response
    {
        return $inertia->render('Notes/create');
    }

    public function store(Request $request)
    {
        $validatedRequest = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'urgency' => 'required|integer',
            'state' => 'required|string|max:255',
        ]);
        Note::create($validatedRequest);

        return redirect()->route('notes.index')->with('success', 'Note created successfully.');
    }

    public function show(Note $note)
    {
        return Inertia::render('Notes/show', compact('note'));
    }

    public function edit(Note $note)
    {
        return Inertia::render('Notes/edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'urgency' => 'required|integer',
            'state' => 'required|string|max:255',
        ]);

        $note->update($validatedData);

        return redirect()->route('notes.index')->with('success', 'Note updated successfully.');
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted successfully.');
    }
}
