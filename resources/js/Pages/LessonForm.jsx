import { Link, useForm } from '@inertiajs/react';
import Layout from '../Components/Layout';

export default function LessonForm({ entry, classes, subjects, teachers, rooms, days }) {
    const isEdit = !!entry;
    const { data, setData, post, put, processing, errors } = useForm({
        school_class_id: entry?.school_class_id ?? classes[0]?.id ?? '',
        subject_id: entry?.subject_id ?? subjects[0]?.id ?? '',
        teacher_id: entry?.teacher_id ?? teachers[0]?.id ?? '',
        room_id: entry?.room_id ?? rooms[0]?.id ?? '',
        day_of_week: entry?.day_of_week ?? 1,
        start_time: entry?.start_time?.slice(0, 5) ?? '08:00',
        end_time: entry?.end_time?.slice(0, 5) ?? '09:00',
    });
    const submit = (e) => {
        e.preventDefault();
        if (isEdit) put(`/timetable/${entry.id}`);
        else post('/timetable');
    };
    const field = 'mt-1 w-full rounded-md border border-slate-300 bg-white px-3 py-2';
    const err = (k) => errors[k] && <p className="mt-1 text-sm text-red-600">{errors[k]}</p>;

    return (
        <Layout>
            <form onSubmit={submit} className="mx-auto max-w-xl rounded-2xl bg-white p-6 shadow ring-1 ring-slate-200">
                <h2 className="font-serif text-2xl">{isEdit ? 'Edit lesson' : 'Add lesson'}</h2>
                <div className="mt-4 grid gap-3 sm:grid-cols-2">
                    <div><label className="text-sm text-slate-500">Class</label>
                        <select value={data.school_class_id} onChange={(e) => setData('school_class_id', e.target.value)} className={field}>
                            {classes.map((c) => <option key={c.id} value={c.id}>{c.name}</option>)}
                        </select></div>
                    <div><label className="text-sm text-slate-500">Subject</label>
                        <select value={data.subject_id} onChange={(e) => setData('subject_id', e.target.value)} className={field}>
                            {subjects.map((s) => <option key={s.id} value={s.id}>{s.name}</option>)}
                        </select></div>
                    <div><label className="text-sm text-slate-500">Teacher</label>
                        <select value={data.teacher_id} onChange={(e) => setData('teacher_id', e.target.value)} className={field}>
                            {teachers.map((t) => <option key={t.id} value={t.id}>{t.name}</option>)}
                        </select></div>
                    <div><label className="text-sm text-slate-500">Room</label>
                        <select value={data.room_id} onChange={(e) => setData('room_id', e.target.value)} className={field}>
                            {rooms.map((r) => <option key={r.id} value={r.id}>{r.name}</option>)}
                        </select></div>
                    <div><label className="text-sm text-slate-500">Day</label>
                        <select value={data.day_of_week} onChange={(e) => setData('day_of_week', e.target.value)} className={field}>
                            {days.map((d) => <option key={d.num} value={d.num}>{d.name}</option>)}
                        </select></div>
                    <div className="grid grid-cols-2 gap-2">
                        <div><label className="text-sm text-slate-500">Start</label>
                            <input type="time" value={data.start_time} onChange={(e) => setData('start_time', e.target.value)} className={field} /></div>
                        <div><label className="text-sm text-slate-500">End</label>
                            <input type="time" value={data.end_time} onChange={(e) => setData('end_time', e.target.value)} className={field} /></div>
                    </div>
                </div>
                {err('conflict')}
                {err('start_time')}{err('end_time')}
                <div className="mt-5 flex gap-3">
                    <button disabled={processing} className="rounded-lg bg-indigo-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-600">Save</button>
                    <Link href="/timetable" className="rounded-lg px-4 py-2.5 text-sm text-slate-500 hover:underline">Back</Link>
                </div>
            </form>
        </Layout>
    );
}
