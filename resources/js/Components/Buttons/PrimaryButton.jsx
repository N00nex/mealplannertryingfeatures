
export default function PrimaryButton({ children, className = "", ...props }) {
    return (
        <button
            type="button"
            className={`rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 ${className}`}
            {...props}
        >
            {children}
        </button>
    );
}
