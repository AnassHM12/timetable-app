import { Link, router } from '@inertiajs/react';
import Layout from '../Components/Layout';
import Pager from '../Components/Pager';

export default function Teachers({ teachers, meta }) {
    const del = (id) => { if (confirm('Delete this teacher?')) router.delete(`/teachers/${id}`); };
    return (
        <Layout>
            <div className="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <div className="flex items-center justify-between">
                    <h2 className="font-serif text-2xl">Teachers</h2>
                    <Link href="/teachers/create" className="rounded-lg bg-indigo-700 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-600">+ Add</Link>
                </div>
                <div className="mt-3 divide-y divide-slate-100">
                    {teachers.map((t) => (
                        <div key={t.id} className="flex items-center gap-3 py-2.5">
                            <span className="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-800">
                                {t.name.split(' ').map((w) => w[0]).join('').slice(0, 2).toUpperCase()}
                            </span>
                            <div><p className="font-medium">{t.name}</p>
                            <p className="text-sm text-slate-500">{t.email} {t.phone && `· ${t.phone}`}</p></div>
                            <span className="ml-auto flex gap-2 text-sm">
                                <Link href={`/teachers/${t.id}/edit`} className="text-indigo-700 hover:underline">Edit</Link>
                                <button onClick={() => del(t.id)} className="text-red-600 hover:underline">Delete</button>
                            </span>
                        </div>
                    ))}
                </div>
                <Pager meta={meta} filters={{}} base="/teachers" />
            </div>
        </Layout>
    );
}
