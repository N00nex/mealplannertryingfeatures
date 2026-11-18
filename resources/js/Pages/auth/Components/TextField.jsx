import { useId, useState } from 'react'

export default function TextField({
    label,
    name,
    value,
    onChange,
    error,
    type = 'text',
    viewable = false,
    labelAside = null,
    ...inputProps
}) {
    const id = useId()
    const [visible, setVisible] = useState(false)
    const inputType = viewable && visible ? 'text' : type

    return (
        <div className="flex flex-col gap-1.5">
            <div className="flex items-center justify-between">
                <label htmlFor={id} className="text-sm font-medium text-zinc-800">
                    {label}
                </label>
                {labelAside}
            </div>

            <div className="relative">
                <input
                    id={id}
                    name={name}
                    type={inputType}
                    value={value}
                    onChange={(event) => onChange(event.target.value)}
                    className="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-xs placeholder:text-zinc-400 focus:border-zinc-400 focus:outline-none"
                    {...inputProps}
                />
                {viewable && (
                    <button
                        type="button"
                        onClick={() => setVisible((current) => !current)}
                        className="absolute inset-y-0 right-0 cursor-pointer px-3 text-xs text-zinc-500 hover:text-zinc-800"
                        aria-label={visible ? 'Hide password' : 'Show password'}
                    >
                        {visible ? 'Hide' : 'Show'}
                    </button>
                )}
            </div>

            {error && <p className="text-sm text-red-600">{error}</p>}
        </div>
    )
}
