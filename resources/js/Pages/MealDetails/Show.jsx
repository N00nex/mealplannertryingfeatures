import React from 'react';
import { Link, router } from '@inertiajs/react';
import Navbar from '../../Layout/Navbar.jsx';

export default function Show({ recipe }) {
    if (!recipe) return <div className="p-8 text-center">Loading...</div>;

    // Funktion zum Löschen des Rezepts
    const handleDelete = () => {
        if (confirm('Möchtest du dieses Rezept wirklich löschen?')) {
            router.delete(route('mealplanner.destroy', recipe.id));
        }
    };

    return (
        <main className="min-h-svh bg-ttb10-bg px-4 py-8 font-ttb10-sans text-ttb10-ink">
            <Navbar />

            <div className="mx-auto w-full max-w-7xl">
                {/* Zurück-Button */}
                <div className="mb-6">
                    <Link
                        href="/mealplanner"
                        className="inline-block rounded border border-ttb10-line bg-ttb10-surface px-4 py-1.5 text-sm font-medium hover:bg-ttb10-time"
                    >
                        Zurück
                    </Link>
                </div>

                <div style={{ padding: '20px', fontFamily: 'monospace' }}>
                    <h1>Recipe Inspector</h1>

                    {/* This will output the entire raw JSON object cleanly */}
                    <pre style={{ background: '#f4f4f4', padding: '15px', borderRadius: '5px', overflowX: 'auto' }}>
                {JSON.stringify({ recipe}, null, 2)}
            </pre>
                </div>
                {/* Rezepttitel */}
                <header className="mb-6">
                    <h1 className="text-3xl font-extrabold tracking-[-0.02em]">{recipe.name}</h1>
                </header>

                {/* Hauptbereich: Grid aus Inhalt (links) und Bild-Platzhalter (rechts) */}
                <div className="grid grid-cols-1 gap-8 lg:grid-cols-3">

                    {/* Linke Spalte (2 Spalten breit): Infos, Zutaten, Tags */}
                    <div className="space-y-6 lg:col-span-2">

                        {/* Box 1: Speiseinformationen */}
                        <div className="border border-ttb10-line bg-ttb10-surface">
                            <div className="flex items-center justify-between border-b border-ttb10-line bg-ttb10-time px-4 py-2 text-sm font-bold">
                                <span>Speiseinformationen;</span>
                                <span className="cursor-pointer text-xs font-normal text-ttb10-mut">--Einklappen--</span>
                            </div>

                            <div className="p-6">
                                <div className="flex flex-wrap items-start justify-between gap-6">
                                    {/* Schwierigkeit & Zubereitungszeit */}
                                    <div className="flex gap-12">
                                        <div>
                                            <h3 className="text-sm font-bold text-ttb10-ink">Schwierigkeitslevel</h3>
                                            <p className="mt-1 text-sm text-ttb10-mut">
                                                {recipe.difficulty ? recipe.difficulty.charAt(0).toUpperCase() + recipe.difficulty.slice(1) : 'Simpel'}
                                            </p>
                                        </div>
                                        <div>
                                            <h3 className="text-sm font-bold text-ttb10-ink">Zubereitungszeit</h3>
                                            <div className="mt-1 flex items-center rounded border border-ttb10-line bg-white px-3 py-1 text-sm">
                                                <span>{recipe.cooking_time || 0}</span>
                                                <span className="ml-2 text-ttb10-mut">Minuten</span>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Action Buttons */}
                                    <div className="flex flex-col gap-2">
                                        <Link
                                            href={`/meal-details/${recipe.id}/edit`}
                                            className="rounded border border-ttb10-line bg-ttb10-surface px-4 py-1.5 text-center text-sm font-medium hover:bg-ttb10-time"
                                        >
                                            Rezept anpassen
                                        </Link>
                                        <button
                                            onClick={handleDelete}
                                            className="rounded border border-red-300 bg-red-50 px-4 py-1.5 text-center text-sm font-medium text-red-700 hover:bg-red-100"
                                        >
                                            Rezept löschen
                                        </button>
                                    </div>
                                </div>

                                {/* Unterer Bereich der Box: Zutaten und Tags */}
                                <div className="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2">

                                    {/* Zutaten Tabelle */}
                                    <div>
                                        <h3 className="mb-3 font-bold text-ttb10-ink">Zutaten</h3>
                                        <div className="overflow-x-auto border border-ttb10-line">
                                            <table className="w-full text-left text-sm">
                                                <thead className="border-b border-ttb10-line bg-ttb10-time">
                                                <tr>
                                                    <th className="px-3 py-2 font-medium">Zutat</th>
                                                    <th className="px-3 py-2 font-medium">Menge</th>
                                                    <th className="px-3 py-2 font-medium">Einheit</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {recipe.ingredients?.map((item) => (
                                                    <tr key={item.id} className="border-b border-ttb10-line last:border-b-0">
                                                        <td className="flex items-center justify-between px-3 py-2.5">
                                                            <span>{item.lebensmittel?.name}</span>
                                                            <span className="cursor-pointer text-xs text-ttb10-mut" title="Info">ℹ️</span>
                                                        </td>
                                                        <td className="px-3 py-2.5">{item.quantity}</td>
                                                        <td className="px-3 py-2.5">
                                                            {item.unit?.unit} {item.unit?.symbol ? `(${item.unit.symbol})` : ''}
                                                        </td>
                                                    </tr>
                                                ))}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {/* Tags Box */}
                                    <div>
                                        <h3 className="mb-3 font-bold text-ttb10-ink">Tags</h3>
                                        <div className="min-h-24 rounded border border-ttb10-line bg-white p-3 text-sm">
                                            {recipe.tags && recipe.tags.length > 0 ? (
                                                recipe.tags.map(tag => tag.name?.en ?? tag.name).join(', ')
                                            ) : (
                                                <span className="text-ttb10-mut">Keine Tags vorhanden</span>
                                            )}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    {/* Rechte Spalte (1 Spalte breit): Blauer Bild-Platzhalter */}
                    <div className="lg:col-span-1">
                        <div className="relative flex h-96 w-full items-center justify-center border-2 border-blue-400 bg-blue-200">
                            {/* Diagonale Linien als X-Muster im Platzhalter wie im Mockup */}
                            <div className="absolute inset-0 overflow-hidden">
                                <div className="absolute left-0 top-0 h-[141%] w-[1px] origin-top-left rotate-[51deg] bg-blue-400" />
                                <div className="absolute right-0 top-0 h-[141%] w-[1px] origin-top-right -rotate-[51deg] bg-blue-400" />
                            </div>
                        </div>
                    </div>

                </div>

                {/* Unterer Abschnitt: Zubereitungsschritte */}
                <div className="mt-8 border border-ttb10-line bg-ttb10-surface">
                    <div className="flex items-center justify-between border-b border-ttb10-line bg-ttb10-time px-4 py-2 text-sm font-bold">
                        <span>Speiseinformationen;</span>
                        <span className="cursor-pointer text-xs font-normal text-ttb10-mut">--Einklappen--</span>
                    </div>

                    <div className="space-y-8 p-6">
                        {recipe.cooking_steps && recipe.cooking_steps.length > 0 ? (
                            recipe.cooking_steps.map((step, index) => {
                                // Berechne Stunden und Minuten aus assigned_time (falls in Minuten gespeichert)
                                const totalMinutes = step.assigned_time || 0;
                                const hours = Math.floor(totalMinutes / 60);
                                const minutes = totalMinutes % 60;

                                return (
                                    <div key={step.id || index} className="flex flex-col justify-between gap-6 border-b border-ttb10-line pb-6 last:border-b-0 last:pb-0 md:flex-row md:items-center">
                                        <div className="space-y-2">
                                            <h3 className="text-xl font-bold text-ttb10-ink">{index + 1}.</h3>
                                            <p className="max-w-xl text-sm leading-relaxed text-ttb10-ink">
                                                {step.description}
                                            </p>
                                        </div>

                                        <div className="flex items-center gap-6">
                                            {/* Zeit-Badge */}
                                            <div className="flex items-center rounded border border-ttb10-line bg-white px-2 py-1 text-xs">
                                                <span className="px-1.5 font-medium">{hours}</span>
                                                <span className="text-ttb10-mut">h</span>
                                                <span className="px-1.5 font-medium">{minutes}</span>
                                                <span className="text-ttb10-mut">min</span>
                                            </div>

                                            {/* Kleiner Bild-Platzhalter pro Schritt (falls im Mockup angedeutet) */}
                                            <div className="relative flex h-24 w-32 shrink-0 items-center justify-center border-2 border-blue-400 bg-blue-200">
                                                <div className="absolute inset-0 overflow-hidden">
                                                    <div className="absolute left-0 top-0 h-[141%] w-[1px] origin-top-left rotate-[37deg] bg-blue-400" />
                                                    <div className="absolute right-0 top-0 h-[141%] w-[1px] origin-top-right -rotate-[37deg] bg-blue-400" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                );
                            })
                        ) : (
                            <p className="text-sm text-ttb10-mut">Keine Zubereitungsschritte hinterlegt.</p>
                        )}
                    </div>
                </div>
            </div>
        </main>
    );
}
