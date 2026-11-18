import { Link, useForm } from '@inertiajs/react'
import IngredientsSection from './Components/IngredientsSection.jsx'
import RecipeInformation from './Components/RecipeInformation.jsx'
import TagsSection from './Components/TagsSection.jsx'
import CookingStepsSection from './Components/CookingStepsSection.jsx'
import RecipeImagePanel from './Components/RecipeImagePanel.jsx'
import Navbar from '../../Layout/Navbar.jsx'
import BackButton from '../../Components/Buttons/BackButton.jsx'


export default function Edit({ recipe, allLebensmittel = [], units = [] }) {
   const form = useForm({
        name: recipe.name,
        difficulty: recipe.difficulty,
        cooking_time: recipe.cooking_time,
        servings: recipe.servings,
        tags: recipe.tags.map(tag => tag.id),
        cooking_steps: (recipe.cooking_steps ?? []).map(step => ({
            id: step.id,
            instructions: step.instructions ?? '',
            preparation_time: step.preparation_time ?? 0,
        })),
        lebensmittel: recipe.lebensmittel.map(lebensmittel => ({
            id: lebensmittel.id,
            pivot: {
                unit_id: lebensmittel.pivot.unit_id,
                quantity: lebensmittel.pivot.quantity
            }
        }))
       ,})

    const saveChanges = (event) => {
        event.preventDefault()
        form.patch(`/meal-details/${recipe.id}`)
    }

    return (
        <main className="min-h-svh bg-slate-50 text-slate-800">
            <Navbar />

            <form onSubmit={saveChanges}>
                <div className="mx-auto max-w-7xl px-4 py-4">
                    <div className="flex items-center justify-between">
                        <Link
                            href={`/meal-details/${recipe.id}`}
                            className="inline-flex items-center gap-2 text-sm text-slate-600"
                        >
                            <BackButton />
                        </Link>

                        <div className="flex items-center gap-2">
                            {/* Cancel button: Uses Inertia Link to go back without saving */}
                            <Link
                                href={`/meal-details/${recipe.id}`}
                                className="rounded-md border border-slate-500 bg-white px-4 py-2 text-sm font-semibold"
                            >
                                Abbrechen
                            </Link>

                            {/* Save button: Regular submit button tied to the form's onSubmit */}
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
                                lebensmittelOptions={allLebensmittel}
                                units={units}
                                servings={form.data.servings}
                                setData={form.setData}
                                // Hier direkt mit Fallback übergeben
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
