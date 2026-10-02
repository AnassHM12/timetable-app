import { Link, router } from '@inertiajs/react';
import Layout from '../Components/Layout';

const COLORS = [
    'bg-blue-100 text-blue-900 border-blue-300', 'bg-emerald-100 text-emerald-900 border-emerald-300',
    'bg-amber-100 text-amber-900 border-amber-300', 'bg-rose-100 text-rose-900 border-rose-300',
    'bg-violet-100 text-violet-900 border-violet-300', 'bg-cyan-100 text-cyan-900 border-cyan-300',
];

export default function Grid({ classes, selectedClass, days, entriesByDay, stats }) {
    return (
        <Layout>
            <div className="rounded-2xl bg-indigo-900 p-8 text-white shadow md:p-10">
                <div className="max-w-2xl">
                    <p className="text-xs font-semibold uppercase tracking-widest text-amber-300">Weekly timetable</p>
                    <h1 className="mt-2 font-serif text-4xl">{selectedClass ? selectedClass.name : 'No classes yet'}</h1>
                    <p className="mt-3 text-indigo-200">
                        Every lesson for the week at a glance. Pick a class, add lessons, and clashes get flagged before they save.
                    </p>
                    <div className="mt-5 flex flex-wrap items-center gap-3">
                        <select value={selectedClass?.id ?? ''} onChange={(e) => router.get('/', { school_class_id: e.target.value })}
                            className="rounded-lg bg-white px-3 py-2 text-sm text-slate-800">
                            {classes.map((c) => <option key={c.id} value={c.id}>{c.name}</option>)}
                        </select>
                        <Link href="/timetable/create" className="rounded-lg bg-amber-400 px-4 py-2 text-sm font-semibold text-indigo-950 hover:bg-amber-300">
                            + Add lesson
                        </Link>
                    </div>
                    {stats && (
                        <div className="mt-6 flex gap-6 text-sm text-indigo-200">
                            <span><strong className="text-white">{stats.lessons}</strong> lessons</span>
                            <span><strong className="text-white">{stats.teachers}</strong> teachers</span>
                            <span><strong className="text-white">{stats.rooms}</strong> rooms</span>
                        </div>
                    )}
                </div>
            </div>

            {selectedClass && (
                <div className="mt-6 grid gap-4 md:grid-cols-5">
                    {days.map((d) => (
                        <div key={d.num} className="rounded-xl bg-white p-3 shadow-sm ring-1 ring-slate-200">
                            <p className="border-b border-slate-100 pb-2 text-sm font-semibold">{d.name}</p>
                            <div className="mt-2 space-y-2">
                                {(entriesByDay[d.num] ?? []).map((e) => (
                                    <div key={e.id} className={`rounded-md border-l-4 px-2.5 py-2 text-xs ${COLORS[e.subject_id % COLORS.length]}`}>
                                        <p className="font-bold">{e.start}–{e.end}</p>
                                        <p className="font-medium">{e.subject}</p>
                                        <p className="opacity-75">{e.teacher} · {e.room}</p>
                                    </div>
                                ))}
                                {(entriesByDay[d.num] ?? []).length === 0 && (
                                    <p className="py-2 text-center text-xs text-slate-400">Free</p>
                                )}
                            </div>
                        </div>
                    ))}
                </div>
            )}
        </Layout>
    );
}
