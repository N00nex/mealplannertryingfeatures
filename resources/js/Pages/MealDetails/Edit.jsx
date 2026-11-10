import { Link } from '@inertiajs/react'
import IngredientsSection from './Components/IngredientsSection.jsx'
import RecipeImagePanel from './Components/RecipeImagePanel.jsx'
import RecipeInformation from './Components/RecipeInformation.jsx'
import TagsSection from './Components/TagsSection.jsx'
import CookingStepsSection from './Components/CookingStepsSection.jsx'
import BackButton from "../../Components/Buttons/BackButton.jsx";
import Navbar from '../../Layout/Navbar.jsx'

export default function Edit({ recipe = null }) {
    return (
        <main className="min-h-svh bg-slate-50 text-slate-800">
            <Navbar />
            <div className="mx-auto max-w-7xl px-4 py-4">
                <div className="flex items-center justify-between">
                    <Link href={`/mealplanner/${recipe.id}`} className="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800">
                        <BackButton />
                    </Link>

                    <div className="flex items-center gap-2">
                        <Link
                            href={`/mealplanner/${recipe.id}`}
                            className="rounded-md border border-slate-500 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                        >
                            Abbrechen
                        </Link>
                        <button
                            type="button"
                            className="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
                        >
                            Änderungen speichern
                        </button>
                    </div>
                </div>

                <div className="mt-7 grid gap-8 xl:grid-cols-[minmax(0,1fr)_20rem]">
                    <div className="grid gap-8">
                        <RecipeInformation recipe={recipe} editable />
                        <div className="grid gap-8 lg:grid-cols-[minmax(0,1.3fr)_minmax(16rem,1fr)]">
                            <IngredientsSection servings={recipe?.servings ?? 4} editable />
                            <TagsSection tags={recipe?.tags ?? []} editable />
                        </div>
                        <CookingStepsSection steps={recipe?.cooking_steps ?? []} editable />
                    </div>
                    <RecipeImagePanel editable />
                </div>

            </div>
        </main>
    );
}
