import { router } from '@inertiajs/react'
import { useState } from 'react'

export default function ShuffleRecipesButton() {
    const [isShuffling, setIsShuffling] = useState(false)

    function shuffleRecipes() {
        router.reload({
            only: ['recipes'],
            onStart: () => setIsShuffling(true),
            onFinish: () => setIsShuffling(false),
        })
    }

    return (
        <button
            type="button"
            onClick={shuffleRecipes}
            disabled={isShuffling}
            className="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
        >
            {isShuffling ? 'Shuffling...' : 'Shuffle recipes'}
        </button>
    )
}
