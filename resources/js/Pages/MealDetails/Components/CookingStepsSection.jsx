export default function CookingStepsSection({ steps = [], editable = false }) {
    const displayedSteps = steps.length > 0 ? steps : [{ instructions: '' }, { instructions: '' }]

    return (
        <section className="border border-slate-400 bg-white" aria-labelledby="steps-heading">
            <div className="border-b border-slate-400 px-3 py-2">
                <h2 id="steps-heading" className="text-sm font-medium text-slate-700">Speiseinformationen; <span className="float-right">--Einklappen--</span></h2>
            </div>
            <div className="grid gap-8 p-5">
                {displayedSteps.map((step, index) => (
                    <article key={step.id ?? index} className="grid gap-3">
                        <div className="flex flex-wrap items-center justify-between gap-3">
                            <h3 className="text-xl font-bold text-slate-700">{index + 1}.</h3>
                            {editable && <div className="flex gap-2 text-sm"><input className="w-12 border border-slate-400 p-1" defaultValue="0" type="number" /> h <input className="w-12 border border-slate-400 p-1" defaultValue="30" type="number" /> min <button type="button" className="rounded border border-slate-500 px-3 py-1 text-xs hover:bg-slate-100">Schritt Entfernen</button></div>}
                        </div>
                        {editable ? <textarea className="min-h-28 w-full border border-slate-400 p-2 text-sm" defaultValue={step.instructions} placeholder="Zubereitungsschritt eingeben..." /> :
                            <p className="min-h-28 w-full border border-slate-400 bg-slate-50 p-2 text-sm">{step.instructions || 'Keine Anleitung vorhanden.'}</p>}
                    </article>
                ))}
            </div>
        </section>
    )
}
