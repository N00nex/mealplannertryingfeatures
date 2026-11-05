import { Trash } from "lucide-react";
export default function DeleteNote(props) {
    return (
        <button type="submit" className="text-red-400 hover:text-red-300" {...props}>
            <Trash />
        </button>
    );
}
