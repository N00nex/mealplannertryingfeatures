export default function IngredientsSection({
    lebensmittel = [],
    lebensmittelOptions = [],
    units = [],
    setData,
    editable = false,
})
{
    const updateRow = (index, changes) => {
        setData('lebensmittel', lebensmittel.map((row, rowIndex) => {
            if (rowIndex !== index) {
                return row
            }

            const { pivot: pivotChanges, ...rest } = changes

            return {
                ...row,
                ...rest,
                pivot: { ...row.pivot, ...pivotChanges },
            }
        }))
    }

    const addRow = () => {
        setData('lebensmittel', [
            ...lebensmittel,
            { id: '', pivot: { unit_id: '', quantity: '' } },
        ])
    }

    const removeRow = (index) => {
        setData('lebensmittel', lebensmittel.filter((_, rowIndex) => rowIndex !== index))
    }

    return (
        <section className="border border-slate-400 bg-white p-4">
            <div className="mb-3 flex items-center justify-between">
                <h2 className="text-lg font-bold">Zutaten</h2>
            </div>

            <div className="grid gap-2">
                {lebensmittel.map((row, index) => (
                    <div
                        key={index}
                        className="grid gap-2 sm:grid-cols-[1fr_6rem_10rem_auto]"
                    >
                        {/* 1. Lebensmittel Dropdown */}
                        <select
                            className="border border-slate-400 px-2 py-1 bg-white"
                            value={row.id}
                            disabled={!editable}
                            onChange={(event) => updateRow(index, { id: event.target.value })}
                        >
                            <option value="">Lebensmittel wählen</option>
                            {lebensmittelOptions.map((option) => (
                                <option key={option.id} value={option.id}>
                                    {option.name}
                                </option>
                            ))}
                        </select>

                        {/* 2. Menge */}
                        <input
                            type="number"
                            min="0"
                            step="any"
                            className="border border-slate-400 px-2 py-1"
                            value={row.pivot.quantity}
                            disabled={!editable}
                            onChange={(event) => updateRow(index, { pivot: { quantity: event.target.value } })}
                        />

                        {/* 3. Unit Dropdown */}
                        <select
                            className="border border-slate-400 px-2 py-1 bg-white"
                            value={row.pivot.unit_id}
                            disabled={!editable}
                            onChange={(event) => updateRow(index, { pivot: { unit_id: event.target.value } })}
                        >
                            <option value="">Einheit wählen</option>
                            {units.map((unit) => (
                                <option key={unit.id} value={unit.id}>
                                    {unit.unit}
                                </option>
                            ))}
                        </select>

                        {editable && (
                            <button
                                type="button"
                                className="border border-slate-500 px-3 py-1 hover:bg-slate-200"
                                onClick={() => removeRow(index)}
                                aria-label="Zutat entfernen"
                            >
                                ✕
                            </button>
                        )}
                    </div>
                ))}

                {editable && (
                    <button
                        type="button"
                        className="text-left text-blue-700 mt-2 font-medium"
                        onClick={addRow}
                    >
                        + Zutat hinzufügen
                    </button>
                )}
            </div>
        </section>
    )
}
