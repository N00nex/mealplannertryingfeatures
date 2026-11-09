import { router } from '@inertiajs/react';
import { useState } from 'react';
import { ConfirmationDialog } from '../Dialogs/ConfirmationDialog.jsx';
import DeleteButton from "../Buttons/DeleteNoteButton.jsx";
import EditButton from "../Buttons/EditButton.jsx";
import PrimaryButton from "../Buttons/PrimaryButton.jsx";

export default function NotesTable({ notes = [] }) {
    const [deletingNote, setDeletingNote] = useState(null);

    const handleDelete = () => {
        if (!deletingNote) {
            return;
        }

        router.delete(`/notes/${deletingNote.id}`, {
            onSuccess: () => setDeletingNote(null),
        });
    };
    return (
        <>
            <div className="mt-8 flow-root">
                <div className="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div className="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table className="relative min-w-full divide-y divide-white/15">
                        <thead>
                        <tr>
                            <th
                                scope="col"
                                className="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-black sm:pl-0"
                            >
                                Title
                            </th>
                            <th
                                scope="col"
                                className="px-3 py-3.5 text-left text-sm font-semibold text-black "
                            >
                                Description
                            </th>
                            <th
                                scope="col"
                                className="px-3 py-3.5 text-left text-sm font-semibold text-black"
                            >
                                Urgency
                            </th>
                            <th
                                scope="col"
                                className="px-3 py-3.5 text-left text-sm font-semibold text-black"
                            >
                                State
                            </th>
                            <th
                                scope="col"
                                className="py-3.5 pr-4 pl-3 text-right text-sm font-semibold text-black sm:pr-0"
                            >
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody className="divide-y divide-white/200">
                        {notes.map((note) => (
                            <tr key={note.id}>
                                <td className="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-shadow-gray-900 sm:pl-0">
                                    {note.title}
                                </td>
                                <td className="px-3 py-4 text-sm text-gray-900">
                                    {note.content}
                                </td>
                                <td className="px-3 py-4 text-sm whitespace-nowrap text-gray-900">
                                    {note.urgency}
                                </td>
                                <td className="px-3 py-4 text-sm whitespace-nowrap text-gray-900">
                                    {note.state}
                                </td>
                                <td className="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
                                    <EditButton
                                        href={`/notes/${note.id}/edit`}
                                        className="mr-4 text-indigo-400 hover:text-indigo-300"
                                        aria-label={`Edit ${note.title}`}
                                    />
                                    <DeleteButton
                                        onClick={() => setDeletingNote(note)}
                                        aria-label={`Delete ${note.title}`}
                                    >
                                        <span className="sr-only">
                                            , {note.title}
                                        </span>
                                    </DeleteButton>
                                </td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>

            {deletingNote && (
                <ConfirmationDialog
                    deletingNote={deletingNote}
                    setDeletingNote={setDeletingNote}
                    handleDelete={handleDelete}
                />
            )}
        </>
    );
}
