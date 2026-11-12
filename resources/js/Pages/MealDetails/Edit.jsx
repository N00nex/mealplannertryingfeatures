import { Link, useForm } from '@inertiajs/react'
import IngredientsSection from './Components/IngredientsSection.jsx'
import RecipeInformation from './Components/RecipeInformation.jsx'
import TagsSection from './Components/TagsSection.jsx'
import CookingStepsSection from './Components/CookingStepsSection.jsx'
import RecipeImagePanel from './Components/RecipeImagePanel.jsx'
import Navbar from '../../Layout/Navbar.jsx'
import BackButton from '../../Components/Buttons/BackButton.jsx'

export default function Edit({ recipe, allLebensmittel = [], allUnits = [] }) {
    const form = useForm({
        difficulty: recipe?.difficulty ?? 'simple',
        cooking_time: recipe?.cooking_time ?? 30,
        servings: recipe?.servings ?? 4,
        name: recipe?.name ?? '',
        lebensmittel: (recipe?.lebensmittel ?? []).map((l) => ({
            lebensmittel_id: l.id,
            unit_id: l.pivot?.unit_id ?? '',
            quantity: l.pivot?.quantity ?? '',
        })),
        tags: recipe?.tags ?? [],
        cooking_steps: recipe?.cooking_steps ?? [],
    })

    const submit = (event) => {
        event.preventDefault()
        form.patch(`/mealplanner/${recipe.id}`)
    }

    return (
        <main className="min-h-svh bg-slate-50 text-slate-800">
            <Navbar />

            <form onSubmit={submit}>
                <div className="mx-auto max-w-7xl px-4 py-4">
                    <div className="flex items-center justify-between">
                        <Link
                            href={`/mealplanner/${recipe.id}`}
                            className="inline-flex items-center gap-2 text-sm text-slate-600"
                        >
                            <BackButton />
                        </Link>

                        <div className="flex items-center gap-2">
                            <Link
                                href={`/mealplanner/${recipe.id}`}
                                className="rounded-md border border-slate-500 bg-white px-4 py-2 text-sm font-semibold"
                            >
                                Abbrechen
                            </Link>

                            <button
                                type="submit"
                                disabled={form.processing}
                                className="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white disabled:opacity-50"
                            >
                                {form.processing ? 'Speichern...' : 'Änderungen speichern'}
                            </button>
                        </div>
                    </div>

                    <div className="mt-7 grid gap-8 xl:grid-cols-[minmax(0,1fr)_20rem]">
                        <div className="grid gap-8">
                            <RecipeInformation
                                difficulty={form.data.difficulty}
                                cookingTime={form.data.cooking_time}
                                setData={form.setData}
                                errors={form.errors}
                                editable
                            />

                            <IngredientsSection
                                lebensmittel={form.data.lebensmittel}
                                servings={form.data.servings}
                                setData={form.setData}
                                allLebensmittel={allLebensmittel}
                                allUnits={allUnits}
                                editable
                            />

                            <TagsSection
                                tags={form.data.tags}
                                setData={form.setData}
                                editable
                            />

                            <CookingStepsSection
                                steps={form.data.cooking_steps}
                                setData={form.setData}
                                editable
                            />
                        </div>

                        <RecipeImagePanel editable />
                    </div>
                </div>
            </form>
        </main>
    )
}
