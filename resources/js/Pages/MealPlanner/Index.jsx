import { Fragment } from 'react'

const days = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag']
const mealSections = ['Mittagessen', 'Abendessen']

export default function Index( Rezepte) {
    return (
        <main className="min-h-svh bg-ttb10-bg px-4 py-8 font-ttb10-sans text-ttb10-ink">
            <div className="mx-auto w-full max-w-7xl">
                <header className="mb-5">
                    <h1 className="text-2xl font-extrabold tracking-[-0.02em]">Meal planner</h1>
                    <p className="mt-1 text-sm text-ttb10-mut">Weekly meal plan</p>
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
                            {mealSections.map((rezepte) => (
                                <Fragment key={rezepte}>
                                    <tr className="border-t border-ttb10-line">
                                        <th
                                            scope="row"
                                            className="border-r border-ttb10-line bg-ttb10-time px-2 py-2 text-sm font-bold"
                                        >
                                            {rezepte}
                                        </th>
                                        {days.map((day) => (
                                            <td
                                                key={`${rezepte}-${day}-heading`}
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
                                        {days.map((day) => (
                                            <td
                                                key={`${rezepte}-${day}-dish`}
                                                className="h-14 border-r border-ttb10-line px-2 py-3"
                                            />
                                        ))}
                                    </tr>
                                    <tr className="border-t border-ttb10-line">
                                        <th
                                            scope="row"
                                            className="border-r border-ttb10-line px-2 py-3 text-sm font-medium text-ttb10-mut"
                                        >
                                            Tags
                                        </th>
                                        {days.map((day) => (
                                            <td
                                                key={`${rezepte}-${day}-tags`}
                                                className="h-14 border-r border-ttb10-line bg-ttb10-time px-2 py-3"
                                            />
                                        ))}
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
