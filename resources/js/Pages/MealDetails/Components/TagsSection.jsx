export default function TagsSection({ tags = [], setData }) {
    const toggleTag = (tag) => {
        const tagId = tag.id ?? tag.name
        const isSelected = tags.some(
            (selectedTag) => (selectedTag.id ?? selectedTag.name) === tagId,
        )

        setData(
            'tags',
            isSelected
                ? tags.filter(
                    (selectedTag) =>
                        (selectedTag.id ?? selectedTag.name) !== tagId,
                )
                : [...tags, tag],
        )
    }

    return (
        <section>
            <h2 className="mb-3 text-lg font-bold">Tags</h2>

            <div className="grid gap-2 border border-slate-400 bg-white p-3">
                {tags.length > 0 ? (
                    tags.map((tag) => (
                        <label
                            key={tag.id ?? tag.name}
                            className="flex items-center gap-2"
                        >
                            <input
                                type="checkbox"
                                checked
                                onChange={() => toggleTag(tag)}
                            />

                            {tag.name?.en ?? tag.name}
                        </label>
                    ))
                ) : (
                    <span className="text-slate-500">
                        Noch keine Tags vorhanden.
                    </span>
                )}
            </div>
        </section>
    )
}
