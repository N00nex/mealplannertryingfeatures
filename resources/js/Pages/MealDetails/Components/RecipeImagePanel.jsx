export default function RecipeImagePanel({ editable = false }) {
    return (
        <aside className="grid content-start gap-4">
            <div className="grid aspect-square place-items-center border border-slate-500 bg-blue-200 text-sm text-slate-600">
                Kein Bild vorhanden
            </div>
            {editable && <div className="flex flex-wrap justify-end gap-3">
                <button type="button" className="rounded border border-slate-500 px-3 py-1 text-sm hover:bg-slate-100">Schritt hinzufügen</button>
                <button type="button" className="rounded border border-slate-500 px-3 py-1 text-sm hover:bg-slate-100">Bild hinzufügen</button>
            </div>}
        </aside>
    )
}
