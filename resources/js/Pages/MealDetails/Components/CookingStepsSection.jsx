export default function CookingStepsSection({
                                                steps = [],
                                                editable = false,
                                                setData,
                                            }) {
    const handleStepChange = (index, field, value) => {
        const updatedSteps = steps.map((step, stepIndex) => {
            if (stepIndex !== index) {
                return step
            }

            return {
                ...step,
                [field]: value,
            }
        })

        setData('cooking_steps', updatedSteps)
    }

    const addStep = () => {
        setData('cooking_steps', [
            ...steps,
            {
                instructions: '',
                preparation_time: 0,
            },
        ])
    }

    const removeStep = (index) => {
        setData(
            'cooking_steps',
            steps.filter((_, stepIndex) => stepIndex !== index),
        )
    }

    return (
        <section className="border border-slate-400 bg-white">
            <div className="border-b border-slate-400 px-3 py-2">
                <h2 className="text-sm font-medium text-slate-700">
                    Zubereitungsschritte
                </h2>
            </div>

            <div className="grid gap-8 p-5">
                {steps.map((step, index) => (
                    <article
                        key={step.id ?? index}
                        className="grid gap-3"
                    >
                        <div className="flex items-center justify-between">
                            <h3 className="text-xl font-bold">
                                {index + 1}.
                            </h3>

                            {editable && (
                                <div className="flex items-center gap-2">
                                    <input
                                        type="number"
                                        min="0"
                                        value={step.preparation_time ?? 0}
                                        onChange={(event) => {
                                            handleStepChange(
                                                index,
                                                'preparation_time',
                                                Number(event.target.value),
                                            )
                                        }}
                                        className="w-20 border border-slate-400 p-1"
                                    />

                                    <span>Minuten</span>

                                    <button
                                        type="button"
                                        onClick={() => removeStep(index)}
                                        className="rounded border border-slate-500 px-3 py-1 text-xs"
                                    >
                                        Schritt entfernen
                                    </button>
                                </div>
                            )}
                        </div>

                        {editable ? (
                            <textarea
                                value={step.instructions ?? ''}
                                onChange={(event) => {
                                    handleStepChange(
                                        index,
                                        'instructions',
                                        event.target.value,
                                    )
                                }}
                                className="min-h-28 w-full border border-slate-400 p-2 text-sm"
                                placeholder="Zubereitungsschritt eingeben..."
                            />
                        ) : (
                            <p className="min-h-28 w-full border border-slate-400 bg-slate-50 p-2 text-sm">
                                {step.instructions || 'Keine Anleitung vorhanden.'}
                            </p>
                        )}
                    </article>
                ))}

                {editable && (
                    <button
                        type="button"
                        onClick={addStep}
                        className="text-left text-blue-700"
                    >
                        + Neuen Schritt hinzufügen
                    </button>
                )}
            </div>
        </section>
    )
}
