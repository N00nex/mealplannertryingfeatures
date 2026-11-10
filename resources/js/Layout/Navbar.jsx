import { Link } from '@inertiajs/react'

const defaultItems = [
    { label: 'Speiseplan', href: '/' },
    { label: 'Rezepte', href: '/recipes' },
    { label: 'Kühlschrank', href: '/ingredients' },
    { label: 'Einkaufsliste', href: '/shopping-list' },
    { label: 'Account', href: '/settings/profile' },
]

export default function Navbar({ items = defaultItems, children }) {
    return (
        <header className="border-b border-slate-500 bg-slate-200">
            <div className="border-b border-slate-400 py-1 text-center text-xs">
                Mealprep
            </div>

            <div className="flex flex-wrap items-center gap-2 p-2">
                <Link
                    href="/"
                    className="mr-4 text-2xl font-semibold text-slate-900"
                >
                    Mealplanner<span className="text-green-600">☘</span>
                </Link>

                {items.map((item) => (
                    <Link
                        key={item.label}
                        href={item.href}
                        className="min-h-10 flex-1 rounded border border-slate-500 bg-slate-200 px-4 py-2 text-center text-sm hover:bg-slate-300"
                    >
                        {item.label}
                    </Link>
                ))}
            </div>

            {children}
        </header>
    )
}
