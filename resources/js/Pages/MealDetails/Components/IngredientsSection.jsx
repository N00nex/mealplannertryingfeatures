export default function IngredientsSection({ingredients = [], servings, setData,})
{const updateIngredient = (index, field, value) => {
        const updatedIngredients = ingredients.map((ingredient, ingredientIndex) =>
            ingredientIndex === index
                ? { ...ingredient, [field]: value }
                : ingredient,
        )

        setData('ingredients', updatedIngredients)
    }

    const addIngredient = () => {
        setData('ingredients', [
            ...ingredients,
            { name: '', amount: '', unit: '' },
        ])
    }

    const removeIngredient = (index) => {
        setData(
            'ingredients',
            ingredients.filter((_, ingredientIndex) => ingredientIndex !== index),
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
                {ingredients.map((ingredient, index) => (
                    <div
                        key={ingredient.id ?? index}
                        className="grid gap-2 sm:grid-cols-[1fr_6rem_10rem_auto]"
                    >
                        <input
                            value={ingredient.name ?? ''}
                            onChange={(event) => {
                                updateIngredient(index, 'name', event.target.value)
                            }}
                            placeholder="Zutat"
                            className="border border-slate-400 px-2 py-1"
                        />

                        <input
                            value={ingredient.amount ?? ''}
                            onChange={(event) => {
                                updateIngredient(index, 'amount', event.target.value)
                            }}
                            placeholder="Menge"
                            className="border border-slate-400 px-2 py-1"
                        />

                        <input
                            value={ingredient.unit ?? ''}
                            onChange={(event) => {
                                updateIngredient(index, 'unit', event.target.value)
                            }}
                            placeholder="Einheit"
                            className="border border-slate-400 px-2 py-1"
                        />

                        <button
                            type="button"
                            onClick={() => removeIngredient(index)}
                            className="border border-slate-500 px-3 py-1"
                        >
                            Entfernen
                        </button>
                    </div>
                ))}

                <button
                    type="button"
                    onClick={addIngredient}
                    className="text-left text-blue-700"
                >
                    + Neue Zutat hinzufügen
                </button>
            </div>
        </section>
    )
}
