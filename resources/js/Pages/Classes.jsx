import { Link, router } from '@inertiajs/react';
import Layout from '../Components/Layout';
import Pager from '../Components/Pager';

export default function Classes({ classes, meta }) {
    const del = (id) => { if (confirm('Delete this class?')) router.delete(`/classes/${id}`); };
    return (
        <Layout>
            <div className="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <div className="flex items-center justify-between">
                    <h2 className="font-serif text-2xl">Classes</h2>
                    <Link href="/classes/create" className="rounded-lg bg-indigo-700 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-600">+ Add</Link>
                </div>
                <div className="mt-3 divide-y divide-slate-100">
                    {classes.map((c) => (
                        <div key={c.id} className="flex items-center gap-3 py-2.5">
                            <span className="rounded-md bg-indigo-700 px-2.5 py-1 text-sm font-bold text-white">{c.name}</span>
                            <span className="text-sm text-slate-500">{c.grade_level}</span>
                            <span className="ml-auto flex gap-2 text-sm">
                                <Link href={`/classes/${c.id}/edit`} className="text-indigo-700 hover:underline">Edit</Link>
                                <button onClick={() => del(c.id)} className="text-red-600 hover:underline">Delete</button>
                            </span>
                        </div>
                    ))}
                </div>
                <Pager meta={meta} filters={{}} base="/classes" />
            </div>
        </Layout>
    );
}
