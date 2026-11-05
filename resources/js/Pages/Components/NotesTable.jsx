import { router } from '@inertiajs/react';
import { useState } from 'react';
import { ConfirmationModal } from './ConfirmationModal.jsx';
import {Trash} from "lucide-react";
import DeleteNote from "./DeleteNote.jsx";
import EditNote from "./EditNote.jsx";

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
                                className="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-white sm:pl-0"
                            >
                                Title
                            </th>
                            <th
                                scope="col"
                                className="px-3 py-3.5 text-left text-sm font-semibold text-white"
                            >
                                Description
                            </th>
                            <th
                                scope="col"
                                className="px-3 py-3.5 text-left text-sm font-semibold text-white"
                            >
                                Urgency
                            </th>
                            <th
                                scope="col"
                                className="px-3 py-3.5 text-left text-sm font-semibold text-white"
                            >
                                State
                            </th>
                            <th
                                scope="col"
                                className="py-3.5 pr-4 pl-3 text-right text-sm font-semibold text-white sm:pr-0"
                            >
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody className="divide-y divide-white/10">
                        {notes.map((note) => (
                            <tr key={note.id}>
                                <td className="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-white sm:pl-0">
                                    {note.title}
                                </td>
                                <td className="px-3 py-4 text-sm text-gray-400">
                                    {note.content}
                                </td>
                                <td className="px-3 py-4 text-sm whitespace-nowrap text-gray-400">
                                    {note.urgency}
                                </td>
                                <td className="px-3 py-4 text-sm whitespace-nowrap text-gray-400">
                                    {note.state}
                                </td>
                                <td className="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
                                    <a
                                        href={`/notes/${note.id}/edit`}
                                        className="mr-4 text-indigo-400 hover:text-indigo-300"
                                    >
                                        <EditNote />
                                    </a>
                                    <button
                                        type="button"
                                        onClick={() => setDeletingNote(note)}
                                        className="text-red-400 hover:text-red-300"
                                    >
                                        <DeleteNote />
                                        <span className="sr-only">
                                            , {note.title}
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>

            {deletingNote && (
                <ConfirmationModal
                    deletingNote={deletingNote}
                    setDeletingNote={setDeletingNote}
                    handleDelete={handleDelete}
                />


            )}
        </>
    );
}
