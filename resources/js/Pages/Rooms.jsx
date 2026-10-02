import { Link, router } from '@inertiajs/react';
import Layout from '../Components/Layout';
import Pager from '../Components/Pager';

export default function Rooms({ rooms, meta }) {
    const del = (id) => { if (confirm('Delete this room?')) router.delete(`/rooms/${id}`); };
    return (
        <Layout>
            <div className="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <div className="flex items-center justify-between">
                    <h2 className="font-serif text-2xl">Rooms</h2>
                    <Link href="/rooms/create" className="rounded-lg bg-indigo-700 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-600">+ Add</Link>
                </div>
                <div className="mt-3 divide-y divide-slate-100">
                    {rooms.map((r) => (
                        <div key={r.id} className="flex items-center gap-3 py-2.5">
                            <div><p className="font-medium">{r.name}</p>
                            <p className="text-sm text-slate-500">{r.capacity ? `${r.capacity} seats` : 'Capacity not set'}</p></div>
                            <span className="ml-auto flex gap-2 text-sm">
                                <Link href={`/rooms/${r.id}/edit`} className="text-indigo-700 hover:underline">Edit</Link>
                                <button onClick={() => del(r.id)} className="text-red-600 hover:underline">Delete</button>
                            </span>
                        </div>
                    ))}
                </div>
                <Pager meta={meta} filters={{}} base="/rooms" />
            </div>
        </Layout>
    );
}
