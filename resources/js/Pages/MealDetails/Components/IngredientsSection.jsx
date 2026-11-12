export default function IngredientsSection({lebensmittel = [], servings, setData, allLebensmittel = [], allUnits = []}) {
    const updateIngredient = (index, field, value) => {
        const updatedLebensmittel = lebensmittel.map((item, lebensmittelIndex) =>
            lebensmittelIndex === index
                ? { ...item, [field]: value }
                : item,
        )

        setData('lebensmittel', updatedLebensmittel)
    }

    const addIngredient = () => {
        setData('lebensmittel', [
            ...lebensmittel,
            { lebensmittel_id: '', quantity: '', unit_id: '' },
        ])
    }

    const removeIngredient = (index) => {
        setData(
            'lebensmittel',
            lebensmittel.filter((_, lebensmittelIndex) => lebensmittelIndex !== index),
        )
    }

    return (
        <section className="border border-slate-400 bg-white p-4">
            <div className="mb-3 flex items-center justify-between">
                <h2 className="text-lg font-bold">Zutaten</h2>

                <label className="flex items-center gap-2 text-sm">
                    Rezept für:
                    <input
                        type="number"
                        min="1"
                        value={servings}
                        onChange={(event) => {
                            setData('servings', Number(event.target.value))
                        }}
                        className="h-8 w-16 border border-slate-400 px-2 text-center"
                    />
                </label>
            </div>

            <div className="grid gap-2">
                {lebensmittel.map((item, index) => (
                    <div
                        key={item.id ?? index}
                        className="grid gap-2 sm:grid-cols-[1fr_6rem_10rem_auto]"
                    >
                        {/* 1. Lebensmittel-ID via Dropdown */}
                        <select
                            value={item.lebensmittel_id ?? ''}
                            onChange={(event) => {
                                updateIngredient(index, 'lebensmittel_id', event.target.value)
                            }}
                            className="border border-slate-400 px-2 py-1 bg-white"
                        >
                            <option value="">Zutat wählen...</option>
                            {allLebensmittel.map((l) => (
                                <option key={l.id} value={l.id}>
                                    {l.name}
                                </option>
                            ))}
                        </select>

                        {/* 2. Menge */}
                        <input
                            type="number"
                            step="any"
                            value={item.quantity ?? ''}
                            onChange={(event) => {
                                updateIngredient(index, 'quantity', event.target.value)
                            }}
                            placeholder="Menge"
                            className="border border-slate-400 px-2 py-1"
                        />

                        {/* 3. Unit-ID via Dropdown */}
                        <select
                            value={item.unit_id ?? ''}
                            onChange={(event) => {
                                updateIngredient(index, 'unit_id', event.target.value)
                            }}
                            className="border border-slate-400 px-2 py-1 bg-white"
                        >
                            <option value="">Einheit wählen...</option>
                            {allUnits.map((u) => (
                                <option key={u.id} value={u.id}>
                                    {u.symbol ?? u.name}
                                </option>
                            ))}
                        </select>

                        <button
                            type="button"
                            onClick={() => removeIngredient(index)}
                            className="border border-slate-500 px-3 py-1 bg-slate-100 hover:bg-slate-200"
                        >
                            Entfernen
                        </button>
                    </div>
                ))}

                <button
                    type="button"
                    onClick={addIngredient}
                    className="text-left text-blue-700 mt-2 font-medium"
                >
                    + Neue Zutat hinzufügen
                </button>
            </div>
        </section>
    )
}
