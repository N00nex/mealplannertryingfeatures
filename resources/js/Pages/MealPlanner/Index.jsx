import { Fragment } from 'react'
import ShuffleRecipesButton from './Components/ShuffleRecipesButton.jsx'
import EditButton from "../../Components/Buttons/EditButton.jsx";
import InfoButton from "../../Components/Buttons/InfoButton.jsx";
import Navbar from "../../Layout/Navbar.jsx";

const days = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag']
const mealSections = ['Mittagessen', 'Abendessen']

export default function Index({ recipes = [] }) {
    return (
        <main className="min-h-svh bg-ttb10-bg px-4 py-8 font-ttb10-sans text-ttb10-ink">
            <Navbar />
            <div className="mx-auto w-full max-w-7xl">
                <div className="mb-4">
                    <p className="text-sm text-ttb10-mut">Welcome to your meal planner</p>
                </div>
                <header className="mb-5">
                    <h1 className="text-2xl font-extrabold tracking-[-0.02em]">Meal planner</h1>
                    <div className="flex flex-wrap items-end justify-between gap-3">
                        <p className="mt-1 text-sm text-ttb10-mut">Weekly meal plan</p>
                        <ShuffleRecipesButton />
                    </div>
                </header>

                <div className="overflow-x-auto border border-ttb10-line bg-ttb10-surface">
                    <table className="w-full min-w-205 table-fixed border-collapse text-left">
                        <caption className="sr-only">Weekly meal plan from Monday to Sunday</caption>
                        <thead>
                            <tr className="bg-ttb10-time">
                                <th scope="col" className="w-30 border-r border-ttb10-line px-2 py-2 text-sm font-medium">
                                    <span className="sr-only">Meal details</span>
                                </th>
                                {days.map((day) => (
                                    <th
                                        key={day}
                                        scope="col"
                                        className="border-r border-ttb10-line px-2 py-2 text-sm font-medium"
                                    >
                                        {day}
                                    </th>
                                ))}
                            </tr>
                        </thead>
                        <tbody>
                            {mealSections.map((meal, mealIndex) => (
                                <Fragment key={meal}>
                                    <tr className="border-t border-ttb10-line">
                                        <th
                                            scope="row"
                                            className="border-r border-ttb10-line bg-ttb10-time px-2 py-2 text-sm font-bold"
                                        >
                                            {meal}
                                        </th>
                                        {days.map((day) => (
                                            <td
                                                key={`${meal}-${day}-heading`}
                                                className="border-r border-ttb10-line bg-ttb10-time px-2 py-2"
                                            />
                                        ))}
                                    </tr>
                                    <tr className="border-t border-ttb10-line">
                                        <th
                                            scope="row"
                                            className="border-r border-ttb10-line px-2 py-3 text-sm font-medium text-ttb10-mut"
                                        >
                                            Speise
                                        </th>
                                        {days.map((day, dayIndex) => {
                                            const recipe = recipes[(mealIndex * days.length) + dayIndex]

                                            return (
                                                <td
                                                    key={`${meal}-${day}-dish`}
                                                    className="h-14 border-r border-ttb10-line px-2 py-3"
                                                >
                                                    <div className="flex flex-col items-start gap-1">
                                                        <span>{recipe?.name}</span>

                                                        {recipe && (
                                                            <InfoButton href={`/mealplanner/${recipe.id}`} value={recipe.name} />
                                                        )}
                                                    </div>
                                                </td>
                                            )
                                        })}
                                    </tr>
                                    <tr className="border-t border-ttb10-line">
                                        <th
                                            scope="row"
                                            className="border-r border-ttb10-line px-2 py-3 text-sm font-medium text-ttb10-mut"
                                        >
                                            Tags
                                        </th>
                                        {days.map((day, dayIndex) => {
                                            const recipe = recipes[(mealIndex * days.length) + dayIndex]

                                            return (
                                            <td
                                                key={`${meal}-${day}-tags`}
                                                className="h-14 border-r border-ttb10-line bg-ttb10-time px-2 py-3"
                                            >
                                                {recipe?.tags?.map((tag) => tag.name?.en ?? tag.name).join(', ')}
                                            </td>
                                            )
                                        })}
                                    </tr>
                                </Fragment>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    )
}
