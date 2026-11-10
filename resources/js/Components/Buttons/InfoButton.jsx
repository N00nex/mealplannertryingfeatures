import { Link } from "@inertiajs/react";
import { Info } from "lucide-react";

export default function InfoButton({ href, className = "", ...props }) {
    return (
        <Link
            href={href}
            className={`inline-flex items-center rounded-md p-2 text-indigo-400 transition hover:bg-indigo-400/10 hover:text-indigo-300 ${className}`}
            {...props}
        >
            <Info />
            <span className="sr-only">Edit</span>
        </Link>
    );
}
