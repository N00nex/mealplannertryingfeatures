import NotesTable from "../Components/NotesTable.jsx";

export default function Index({ notes }) {
    return (
        <div className="px-4 sm:px-6 lg:px-8 py-10">
            <div className="sm:flex sm:items-center">
                <div className="sm:flex-auto">
                    <h1 className="text-base font-semibold text-white">Notes Overview</h1>
                    <p className="mt-2 text-sm text-gray-300">
                        A list of all the notes in your account including their title, description, urgency and state.
                    </p>
                </div>
                <div className="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a
                        href="/notes/create"
                        className="block rounded-md bg-indigo-500 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400"
                    >
                        Add note
                    </a>
                </div>
            </div>

            {/* Hier wird das Template gerendert und mit den Daten aus Laravel befüllt */}
            <NotesTable notes={notes} />
        </div>
    )
}
