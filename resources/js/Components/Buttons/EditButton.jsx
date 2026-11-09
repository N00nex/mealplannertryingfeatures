import { Link } from "@inertiajs/react";
import { PenLine } from "lucide-react";

export default function EditButton({ href, className = "", ...props }) {
    return (
        <Link
            href={href}
            className={`inline-flex items-center rounded-md p-2 text-indigo-400 transition hover:bg-indigo-400/10 hover:text-indigo-300 ${className}`}
            {...props}
        >
            <PenLine />
            <span className="sr-only">Edit</span>
        </Link>
    );
}
