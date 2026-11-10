import { Link, router } from '@inertiajs/react'
import IngredientsSection from './Components/IngredientsSection.jsx'
import RecipeImagePanel from './Components/RecipeImagePanel.jsx'
import RecipeInformation from './Components/RecipeInformation.jsx'
import TagsSection from './Components/TagsSection.jsx'
import CookingStepsSection from './Components/CookingStepsSection.jsx'
import BackButton from "../../Components/Buttons/BackButton.jsx";
import Navbar from '../../Layout/Navbar.jsx'
import DeleteButton from "../../Components/Buttons/DeleteButton.jsx";
import { ConfirmationDialog } from "../../Components/Dialogs/ConfirmationDialog.jsx";
import { useState } from "react";
import EditButton from "../../Components/Buttons/EditButton.jsx";

export default function Show({ recipe = null }) {
    const [deletingRecipe, setDeletingRecipe] = useState(null);

    const handleDelete = () => {
        if (!deletingRecipe) {
            return;
        }

        router.delete(`/recipes/${deletingRecipe.id}`, {
            onSuccess: () => setDeletingRecipe(null),
        });
    };

    return (
        <main className="min-h-svh bg-slate-50 text-slate-800">
            <Navbar />
            <div className="mx-auto max-w-7xl px-4 py-4">
                <div className="flex items-center justify-between">
                    <Link href="/" className="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800">
                        <BackButton />
                    </Link>

                    <div className="flex items-center gap-2">
                        <EditButton href={`/mealplanner/${recipe.id}/edit`} />
                        <DeleteButton onClick={() => setDeletingRecipe(recipe)} />
                    </div>
                </div>
                <div className="mt-7 grid gap-8 xl:grid-cols-[minmax(0,1fr)_20rem]">
                    <div className="grid gap-8">
                        <RecipeInformation recipe={recipe} />
                        <div className="grid gap-8 lg:grid-cols-[minmax(0,1.3fr)_minmax(16rem,1fr)]">
                            <IngredientsSection servings={recipe?.servings ?? 4} />
                            <TagsSection tags={recipe?.tags ?? []} />
                        </div>
                        <CookingStepsSection steps={recipe?.cooking_steps ?? []} />
                    </div>
                    <RecipeImagePanel />
                </div>

            </div>
            {deletingRecipe && (
                <ConfirmationDialog
                    item={deletingRecipe}
                    setItem={setDeletingRecipe}
                    onConfirm={handleDelete}
                />
            )}
        </main>
    );
}
