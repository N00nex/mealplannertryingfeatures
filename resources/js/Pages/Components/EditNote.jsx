import { PenLine } from "lucide-react";
export default function EditNote(props) {
    return (
        <button type="submit" className="text-white-400 hover:text-shadow-white-300" {...props}>
            <PenLine />
        </button>
    );
}
