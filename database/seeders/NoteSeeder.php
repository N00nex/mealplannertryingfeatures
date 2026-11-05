<?php

namespace Database\Seeders;

use App\Models\Note;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $notes = [
            [
                'title' => 'Welcome to your notes',
                'content' => 'This is your first note.',
                'urgency' => 1,
                'state' => 'open',
            ],
            [
                'title' => 'Plan the week',
                'content' => 'Add the important tasks for this week.',
                'urgency' => 2,
                'state' => 'open',
            ],
            [
                'title' => 'Completed example',
                'content' => 'This note demonstrates a completed state.',
                'urgency' => 3,
                'state' => 'completed',
            ],
        ];

        foreach ($notes as $note) {
            Note::updateOrCreate(
                ['title' => $note['title']],
                $note,
            );
        }
    }
}
