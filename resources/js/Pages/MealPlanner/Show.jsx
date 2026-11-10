export default function Show({ recipe }) {
    return (
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 className="text-2xl font-bold">{recipe.name}</h1>
            <p className="text-gray-700">{recipe.description}</p>
        </div>
    );
}
