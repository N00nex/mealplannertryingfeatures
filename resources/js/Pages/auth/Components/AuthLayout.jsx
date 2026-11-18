export default function AuthLayout({ title, description, status, children }) {
    return (
        <div className="flex min-h-svh flex-col items-center justify-center gap-6 bg-white p-6 antialiased md:p-10">
            <div className="flex w-full max-w-sm flex-col gap-6">
                <div className="flex w-full flex-col text-center">
                    <h1 className="text-2xl font-semibold text-zinc-900">{title}</h1>
                    <p className="text-sm text-zinc-500">{description}</p>
                </div>

                {status && (
                    <div className="text-center text-sm font-medium text-green-600">{status}</div>
                )}

                {children}
            </div>
        </div>
    )
}
