import { Link, useForm } from '@inertiajs/react'
import { useEffect, useState } from 'react'
import AuthLayout from './Components/AuthLayout.jsx'
import TextField from './Components/TextField.jsx'

export default function Login({
    status = null,
    canResetPassword = true,
    canRegister = true,
    passkeyOptionsUrl,
    passkeyLoginUrl,
}) {
    const form = useForm({
        email: '',
        password: '',
        remember: false,
    })

    const submit = (event) => {
        event.preventDefault()
        form.post('/login', {
            onFinish: () => form.reset('password'),
            // Fortify redirects to the (Livewire) two-factor page, which is not an Inertia response.
            onHttpException: () => {
                window.location.assign('/two-factor-challenge')

                return false
            },
        })
    }

    return (
        <AuthLayout
            title="Log in to your account"
            description="Enter your email and password below to log in"
            status={status}
        >
            <PasskeyLogin optionsUrl={passkeyOptionsUrl} submitUrl={passkeyLoginUrl} />

            <form onSubmit={submit} className="flex flex-col gap-6">
                <TextField
                    label="Email address"
                    name="email"
                    type="email"
                    value={form.data.email}
                    onChange={(value) => form.setData('email', value)}
                    error={form.errors.email}
                    required
                    autoFocus
                    autoComplete="email"
                    placeholder="email@example.com"
                />

                <TextField
                    label="Password"
                    name="password"
                    type="password"
                    value={form.data.password}
                    onChange={(value) => form.setData('password', value)}
                    error={form.errors.password}
                    required
                    autoComplete="current-password"
                    placeholder="Password"
                    viewable
                    labelAside={
                        canResetPassword && (
                            <a
                                href="/forgot-password"
                                className="text-sm text-zinc-700 underline hover:text-zinc-900"
                            >
                                Forgot your password?
                            </a>
                        )
                    }
                />

                <label className="flex items-center gap-2 text-sm text-zinc-800">
                    <input
                        type="checkbox"
                        name="remember"
                        checked={form.data.remember}
                        onChange={(event) => form.setData('remember', event.target.checked)}
                        className="size-4 rounded border-zinc-300"
                    />
                    Remember me
                </label>

                <button
                    type="submit"
                    disabled={form.processing}
                    data-test="login-button"
                    className="w-full cursor-pointer rounded-lg bg-zinc-800 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 disabled:opacity-50"
                >
                    Log in
                </button>
            </form>

            {canRegister && (
                <div className="space-x-1 text-center text-sm text-zinc-600">
                    <span>Don't have an account?</span>
                    <Link href="/register" className="text-zinc-800 underline">
                        Sign up
                    </Link>
                </div>
            )}
        </AuthLayout>
    )
}

function PasskeyLogin({ optionsUrl, submitUrl }) {
    const [Passkeys, setPasskeys] = useState(null)
    const [loading, setLoading] = useState(false)
    const [error, setError] = useState(null)

    useEffect(() => {
        let active = true

        import('@laravel/passkeys').then((module) => {
            if (active && module.Passkeys.isSupported()) {
                setPasskeys(() => module.Passkeys)
            }
        })

        return () => {
            active = false
        }
    }, [])

    if (!Passkeys || !optionsUrl || !submitUrl) {
        return null
    }

    const verify = async () => {
        setLoading(true)
        setError(null)

        try {
            const response = await Passkeys.verify({
                routes: { options: optionsUrl, submit: submitUrl },
            })
            window.location.assign(response.redirect || '/Mealplanner')
        } catch (e) {
            if (e.constructor?.name !== 'UserCancelledError') {
                setError(e.message)
            }
        } finally {
            setLoading(false)
        }
    }

    return (
        <div>
            <div className="grid gap-2">
                <button
                    type="button"
                    onClick={verify}
                    disabled={loading}
                    className="w-full cursor-pointer rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-800 hover:bg-zinc-50 disabled:opacity-50"
                >
                    {loading ? 'Authenticating...' : 'Sign in with a passkey'}
                </button>
                {error && <p className="text-center text-sm text-red-600">{error}</p>}
            </div>

            <div className="relative my-6">
                <div className="absolute inset-0 flex items-center">
                    <div className="w-full border-t border-zinc-200" />
                </div>
                <div className="relative flex justify-center text-xs uppercase">
                    <span className="bg-white px-2 text-zinc-500">Or continue with email</span>
                </div>
            </div>
        </div>
    )
}
