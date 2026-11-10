const defaultIngredients = [
    { name: 'Mehl', amount: '500', unit: 'Gramm (g)' },
    { name: 'Wasser', amount: '200', unit: 'Milliliter (ml)' },
]

export default function IngredientsSection({ ingredients = defaultIngredients, servings = 4, editable = false }) {
    return (
        <section className="border border-slate-400 bg-white p-4" aria-labelledby="ingredients-heading">
            <div className="mb-3 flex flex-wrap items-center justify-between gap-3">
                <h2 id="ingredients-heading" className="text-lg font-bold text-slate-800">Zutaten Hinzufügen</h2>
                {editable ? <label className="flex items-center gap-2 text-sm text-slate-700">Rezept für:
                    <input className="h-8 w-16 border border-slate-400 px-2 text-center" defaultValue={servings} min="1" type="number" />
                </label> : <span className="flex items-center gap-2 text-sm text-slate-700">Rezept für: <strong>{servings}</strong></span>}
            </div>
            <div className="overflow-x-auto border border-slate-400">
                <table className="w-full min-w-[34rem] border-collapse text-left text-sm">
                    <thead className="bg-slate-300 text-slate-700">
                        <tr>
                            <th className="border-r border-slate-400 px-2 py-2 font-medium">Zutat</th>
                            <th className="border-r border-slate-400 px-2 py-2 font-medium">Menge</th>
                            <th className="border-r border-slate-400 px-2 py-2 font-medium">Einheit</th>
                            {editable && <th className="px-2 py-2 font-medium">Zutat entfernen</th>}
                        </tr>
                    </thead>
                    <tbody>
                        {ingredients.map((ingredient) => (
                            <tr key={ingredient.name} className="border-t border-slate-300">
                                <td className="px-2 py-2">{ingredient.name}</td>
                                <td className="px-2 py-2">{ingredient.amount}</td>
                                <td className="px-2 py-2">{ingredient.unit}</td>
                                {editable && <td className="px-2 py-2"><button type="button" className="rounded border border-slate-500 px-3 py-1 text-xs hover:bg-slate-100">Entfernen</button></td>}
                            </tr>
                        ))}
                    </tbody>
                </table>
                {editable && <button type="button" className="w-full border-t border-slate-400 px-2 py-1 text-left text-sm text-blue-700 hover:bg-slate-100">+ Neue Zutat hinzufügen</button>}
            </div>
        </section>
    )
}
