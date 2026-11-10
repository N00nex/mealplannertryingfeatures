export default function RecipeInformation({ recipe, editable = false }) {
    return (
        <section className="rounded border border-slate-400 bg-white p-4" aria-labelledby="recipe-information-heading">
            <h2 id="recipe-information-heading" className="sr-only">Speiseinformationen</h2>
            <div className="grid gap-5 sm:grid-cols-2">
                {editable ? <label className="grid gap-2 text-sm font-semibold text-slate-700">
                    Schwierigkeitslevel
                    <select className="h-9 border border-slate-400 bg-white px-2 font-normal" defaultValue="simple">
                        <option value="simple">Simpel</option>
                        <option value="medium">Mittelschwer</option>
                        <option value="complex">Komplex</option>
                    </select>
                </label> : <div className="grid gap-2 text-sm font-semibold text-slate-700">
                    Schwierigkeitslevel
                    <span className="h-9 border border-slate-400 bg-slate-50 px-2 py-1 font-normal">{recipe?.difficulty ?? 'Simpel'}</span>
                </div>}
                {editable ? <label className="grid gap-2 text-sm font-semibold text-slate-700">
                    Zubereitungszeit
                    <span className="flex h-9 items-center border border-slate-400 px-2 font-normal">
                        <input className="w-14 border-0 p-0 outline-none" defaultValue={recipe?.cooking_time ?? 30} min="0" type="number" />
                        <span className="text-slate-500">Minuten</span>
                    </span>
                </label> : <div className="grid gap-2 text-sm font-semibold text-slate-700">
                    Zubereitungszeit
                    <span className="flex h-9 items-center border border-slate-400 bg-slate-50 px-2 font-normal">{recipe?.cooking_time ?? 30} <span className="ml-1 text-slate-500">Minuten</span></span>
                </div>}
            </div>
        </section>
    )
}
