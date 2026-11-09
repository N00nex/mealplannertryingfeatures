import { ArrowLeft } from 'lucide-react';

export default function BackButton({ children = "Back", className = "", ...props }) {
    return (
        <button
            type="button"
            className={`inline-flex items-center gap-2 rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-gray-300 transition hover:bg-gray-700 ${className}`}
            {...props}
        >
            <ArrowLeft />
            {children}
        </button>
    );
}
