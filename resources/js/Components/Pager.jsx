import { router } from '@inertiajs/react';

export default function Pager({ meta, filters, base }) {
    if (!meta || meta.last_page <= 1) return null;
    const go = (page) => router.get(base, { ...filters, page }, { preserveState: true });
    return (
        <div className="mt-4 flex items-center justify-between text-sm">
            <button disabled={meta.current_page <= 1} onClick={() => go(meta.current_page - 1)}
                className="rounded-md border border-slate-300 px-3 py-1 disabled:opacity-40">Prev</button>
            <span className="text-slate-500">Page {meta.current_page} of {meta.last_page}</span>
            <button disabled={meta.current_page >= meta.last_page} onClick={() => go(meta.current_page + 1)}
                className="rounded-md border border-slate-300 px-3 py-1 disabled:opacity-40">Next</button>
        </div>
    );
}
