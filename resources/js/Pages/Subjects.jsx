import { Link, router } from '@inertiajs/react';
import Layout from '../Components/Layout';
import Pager from '../Components/Pager';

const COLORS = [
    'bg-blue-100 text-blue-900', 'bg-emerald-100 text-emerald-900', 'bg-amber-100 text-amber-900',
    'bg-rose-100 text-rose-900', 'bg-violet-100 text-violet-900', 'bg-cyan-100 text-cyan-900',
];

export default function Subjects({ subjects, meta }) {
    const del = (id) => { if (confirm('Delete this subject?')) router.delete(`/subjects/${id}`); };
    return (
        <Layout>
            <div className="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <div className="flex items-center justify-between">
                    <h2 className="font-serif text-2xl">Subjects</h2>
                    <Link href="/subjects/create" className="rounded-lg bg-indigo-700 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-600">+ Add</Link>
                </div>
                <div className="mt-3 grid gap-3 sm:grid-cols-2">
                    {subjects.map((s, i) => (
                        <div key={s.id} className={`flex items-center gap-3 rounded-lg px-4 py-3 ${COLORS[i % COLORS.length]}`}>
                            <div><p className="font-semibold">{s.name}</p>
                            <p className="text-xs opacity-70">{s.code || 'No code'}</p></div>
                            <span className="ml-auto flex gap-2 text-sm">
                                <Link href={`/subjects/${s.id}/edit`} className="underline">Edit</Link>
                                <button onClick={() => del(s.id)} className="underline">Delete</button>
                            </span>
                        </div>
                    ))}
                </div>
                <Pager meta={meta} filters={{}} base="/subjects" />
            </div>
        </Layout>
    );
}
