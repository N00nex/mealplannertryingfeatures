import { Head, Link } from '@inertiajs/react';

export default function Home() {
    return (
        <>
            <Head title="Home" />

            <main>
                <h1>Meal Planner</h1>
                <p>Inertia.js with React is working.</p>

                <nav>
                    <Link href="/image-upload">Image upload</Link>
                    <Link href="/ingredients">Ingredients</Link>
                </nav>
            </main>
        </>
    );
}
