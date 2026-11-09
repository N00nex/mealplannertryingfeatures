import NotesTable from "../../Components/Tables/NotesTable.jsx";

export default function Index({ notes, user }) {
    return (
        <div className="px-4 sm:px-6 lg:px-8 py-10">
            <div className="sm:flex sm:items-center">
                <div className="sm:flex-auto">
                    <h1 className="text-base font-semibold text-white">Notes Overview</h1>
                    <p className="mt-2 text-sm text-black">
                        A list of all the notes in your account including their title, description, urgency and state.
                    </p>
                </div>
            </div>

            {/* Hier wird das Template gerendert und mit den Daten aus Laravel befüllt */}
            <NotesTable notes={notes} />
            <p>{user.email}</p>
        </div>
    )
}
