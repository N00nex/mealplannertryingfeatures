import { Trash } from "lucide-react";

export default function DeleteButton({ children, ...props }) {
    return (
        <button type="button" className="text-red-400 hover:text-red-300" {...props}>
            <Trash />
            {children}
        </button>
    );
}
