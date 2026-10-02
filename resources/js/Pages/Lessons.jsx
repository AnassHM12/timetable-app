import { Link, router } from '@inertiajs/react';
import Layout from '../Components/Layout';
import Pager from '../Components/Pager';

export default function Lessons({ entries, meta, filters, filterOptions, days }) {
    const set = (patch) => router.get('/timetable', { ...filters, ...patch, page: undefined }, { preserveState: true });
    const del = (id) => { if (confirm('Delete this lesson?')) router.delete(`/timetable/${id}`); };
    const sel = 'rounded-md border border-slate-300 bg-white px-3 py-1.5 text-sm';

    return (
        <Layout>
            <div className="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <div className="flex flex-wrap items-center justify-between gap-3">
                    <h2 className="font-serif text-2xl">Lessons</h2>
                    <Link href="/timetable/create" className="rounded-lg bg-indigo-700 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-600">+ Add lesson</Link>
                </div>
                <div className="mt-3 flex flex-wrap gap-2">
                    <select value={filters.school_class_id ?? ''} onChange={(e) => set({ school_class_id: e.target.value || undefined })} className={sel}>
                        <option value="">All classes</option>
                        {filterOptions.classes.map((c) => <option key={c.id} value={c.id}>{c.name}</option>)}
                    </select>
                    <select value={filters.teacher_id ?? ''} onChange={(e) => set({ teacher_id: e.target.value || undefined })} className={sel}>
                        <option value="">All teachers</option>
                        {filterOptions.teachers.map((t) => <option key={t.id} value={t.id}>{t.name}</option>)}
                    </select>
                    <select value={filters.day_of_week ?? ''} onChange={(e) => set({ day_of_week: e.target.value || undefined })} className={sel}>
                        <option value="">All days</option>
                        {days.map((d) => <option key={d.num} value={d.num}>{d.name}</option>)}
                    </select>
                </div>
                <div className="mt-3 divide-y divide-slate-100">
                    {entries.length === 0 && <p className="py-6 text-center text-sm text-slate-500">No lessons match. Try clearing the filters.</p>}
                    {entries.map((e) => (
                        <div key={e.id} className="flex flex-wrap items-center gap-3 py-3">
                            <span className="w-24 shrink-0 rounded-md bg-indigo-50 px-2 py-1 text-center text-xs font-bold text-indigo-800">{e.day}</span>
                            <span className="text-sm font-semibold">{e.start}–{e.end}</span>
                            <span className="text-sm"><strong>{e.subject}</strong> <span className="text-slate-400">· {e.class}</span></span>
                            <span className="ml-auto text-sm text-slate-500">{e.teacher} · {e.room}</span>
                            <span className="flex gap-2 text-sm">
                                <Link href={`/timetable/${e.id}/edit`} className="text-indigo-700 hover:underline">Edit</Link>
                                <button onClick={() => del(e.id)} className="text-red-600 hover:underline">Delete</button>
                            </span>
                        </div>
                    ))}
                </div>
                <Pager meta={meta} filters={filters} base="/timetable" />
            </div>
        </Layout>
    );
}
