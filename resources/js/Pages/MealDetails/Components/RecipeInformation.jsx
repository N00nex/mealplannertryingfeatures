export default function RecipeInformation({
                                              recipe = null,
                                              difficulty,
                                              cookingTime,
                                              setData,
                                              errors = {},
                                              editable = false,
                                          }) {
    const currentDifficulty = difficulty ?? recipe?.difficulty ?? 'simple'
    const currentCookingTime = cookingTime ?? recipe?.cooking_time ?? 0

    return (
        <section className="rounded border border-slate-400 bg-white p-4">
            <h2 className="sr-only">Speiseinformationen</h2>

            <div className="grid gap-5 sm:grid-cols-2">
                {editable ? (
                    <label className="grid gap-2 text-sm font-semibold">
                        Schwierigkeitslevel

                        <select
                            value={currentDifficulty}
                            onChange={(event) => {
                                setData('difficulty', event.target.value)
                            }}
                            className="h-9 border border-slate-400 bg-white px-2 font-normal"
                        >
                            <option value="simple">Simpel</option>
                            <option value="medium">Mittelschwer</option>
                            <option value="complex">Komplex</option>
                        </select>

                        {errors.difficulty && (
                            <span className="text-sm text-red-600">
                                {errors.difficulty}
                            </span>
                        )}
                    </label>
                ) : (
                    <div className="grid gap-2 text-sm font-semibold">
                        Schwierigkeitslevel
                        <span className="h-9 border border-slate-400 bg-slate-50 px-2 py-1 font-normal">
                            {currentDifficulty}
                        </span>
                    </div>
                )}

                {editable ? (
                    <label className="grid gap-2 text-sm font-semibold">
                        Zubereitungszeit

                        <span className="flex h-9 items-center border border-slate-400 px-2">
                            <input
                                type="number"
                                min="0"
                                value={currentCookingTime}
                                onChange={(event) => {
                                    setData(
                                        'cooking_time',
                                        event.target.value === ''
                                            ? ''
                                            : Number(event.target.value),
                                    )
                                }}
                                className="w-14 border-0 p-0 outline-none"
                            />

                            <span className="font-normal text-slate-500">
                                Minuten
                            </span>
                        </span>

                        {errors.cooking_time && (
                            <span className="text-sm text-red-600">
                                {errors.cooking_time}
                            </span>
                        )}
                    </label>
                ) : (
                    <div className="grid gap-2 text-sm font-semibold">
                        Zubereitungszeit
                        <span className="flex h-9 items-center border border-slate-400 bg-slate-50 px-2 font-normal">
                            {currentCookingTime} Minuten
                        </span>
                    </div>
                )}
            </div>
        </section>
    )
}
