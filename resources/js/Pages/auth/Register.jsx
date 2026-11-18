import { Link, useForm } from '@inertiajs/react'
import AuthLayout from './Components/AuthLayout.jsx'
import TextField from './Components/TextField.jsx'

export default function Register({ status = null }) {
    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    })

    const submit = (event) => {
        event.preventDefault()
        form.post('/register', {
            onFinish: () => form.reset('password', 'password_confirmation'),
        })
    }

    return (
        <AuthLayout
            title="Create an account"
            description="Enter your details below to create your account"
            status={status}
        >
            <form onSubmit={submit} className="flex flex-col gap-6">
                <TextField
                    label="Name"
                    name="name"
                    value={form.data.name}
                    onChange={(value) => form.setData('name', value)}
                    error={form.errors.name}
                    required
                    autoFocus
                    autoComplete="name"
                    placeholder="Full name"
                />

                <TextField
                    label="Email address"
                    name="email"
                    type="email"
                    value={form.data.email}
                    onChange={(value) => form.setData('email', value)}
                    error={form.errors.email}
                    required
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
                    autoComplete="new-password"
                    placeholder="Password"
                    viewable
                />

                <TextField
                    label="Confirm password"
                    name="password_confirmation"
                    type="password"
                    value={form.data.password_confirmation}
                    onChange={(value) => form.setData('password_confirmation', value)}
                    error={form.errors.password_confirmation}
                    required
                    autoComplete="new-password"
                    placeholder="Confirm password"
                    viewable
                />

                <button
                    type="submit"
                    disabled={form.processing}
                    data-test="register-user-button"
                    className="w-full cursor-pointer rounded-lg bg-zinc-800 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 disabled:opacity-50"
                >
                    Create account
                </button>
            </form>

            <div className="space-x-1 text-center text-sm text-zinc-600">
                <span>Already have an account?</span>
                <Link href="/login" className="text-zinc-800 underline">
                    Log in
                </Link>
            </div>
        </AuthLayout>
    )
}
