import BackButton from "../Buttons/BackButton.jsx";
import PrimaryButton from "../Buttons/PrimaryButton.jsx";

export function ConfirmationDialog({ deletingNote, setDeletingNote, handleDelete }) {
    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4">
            <div className="bg-gray-900 border border-white/15 rounded-xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <h3 className="text-lg font-semibold text-white">
                    Delete Entry
                </h3>

                <p className="text-sm text-gray-300">
                    Are you sure you want to delete{" "}
                    <span className="font-bold text-white">
                        "{deletingNote.title || deletingNote.name}"
                    </span>
                    ? This action cannot be undone.
                </p>

                <div className="flex justify-end gap-3 pt-2">
                    <BackButton onClick={() => setDeletingNote(null)} />

                    <PrimaryButton
                        onClick={handleDelete}
                        className="bg-red-600 hover:bg-red-500"
                    >
                        Delete
                    </PrimaryButton>
                </div>
            </div>
        </div>
    );
}
