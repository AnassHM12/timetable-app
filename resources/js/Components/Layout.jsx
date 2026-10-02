import { Link, usePage } from '@inertiajs/react';

export default function Layout({ children }) {
    const { flash } = usePage().props;
    const link = 'text-sm text-indigo-100 hover:text-white';

    return (
        <div className="min-h-screen bg-slate-100 text-slate-800">
            <nav className="bg-indigo-900 text-white">
                <div className="mx-auto flex max-w-6xl flex-wrap items-center gap-5 px-5 py-3.5">
                    <Link href="/" className="text-lg font-semibold">Timetable <span className="font-normal text-amber-300">Manager</span></Link>
                    <Link href="/" className={link}>Grid</Link>
                    <Link href="/timetable" className={link}>Lessons</Link>
                    <Link href="/classes" className={link}>Classes</Link>
                    <Link href="/subjects" className={link}>Subjects</Link>
                    <Link href="/teachers" className={link}>Teachers</Link>
                    <Link href="/rooms" className={link}>Rooms</Link>
                </div>
            </nav>
            <main className="mx-auto max-w-6xl px-5 py-8">
                {flash?.success && (
                    <div className="mb-5 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">
                        {flash.success}
                    </div>
                )}
                {children}
            </main>
            <footer className="pb-8 text-center text-xs text-slate-500">
                Timetable Manager · Laravel + React + SQLite
            </footer>
        </div>
    );
}
