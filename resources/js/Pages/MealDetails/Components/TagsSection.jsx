export default function TagsSection({ tags = [], editable = false }) {
    return (
        <section aria-labelledby="tags-heading">
            <h2 id="tags-heading" className="mb-3 text-lg font-bold text-slate-800">Tags</h2>
            {editable && <div className="grid gap-2 sm:grid-cols-[1fr_auto]">
                <select className="h-9 border border-slate-400 bg-white px-2" defaultValue=""><option value="">Tags auswählen...</option>{tags.map((tag) => <option key={tag.id ?? tag.name} value={tag.id ?? tag.name}>{tag.name?.en ?? tag.name}</option>)}</select>
                <button type="button" className="h-9 rounded border border-slate-500 px-3 text-sm hover:bg-slate-100">Tags Erstellen +</button>
            </div>}
            <div className="mt-2 grid gap-2 border border-slate-400 bg-white p-3 text-sm">
                {tags.length > 0 ? tags.map((tag) => (
                    editable ? <label key={tag.id ?? tag.name} className="flex items-center gap-2"><input type="checkbox" defaultChecked />{tag.name?.en ?? tag.name}</label> :
                    <span key={tag.id ?? tag.name}>
                        {tag.name?.en ?? tag.name}
                    </span>
                )) : <span className="text-slate-500">Noch keine Tags vorhanden.</span>}
            </div>
            {editable && <button type="button" className="mt-2 h-9 rounded border border-slate-500 px-3 text-sm hover:bg-slate-100">Tags Löschen -</button>}
        </section>
    )
}
