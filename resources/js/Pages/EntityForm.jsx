import { Link, useForm } from '@inertiajs/react';
import Layout from '../Components/Layout';

export default function EntityForm({ title, back, fields, item, submitUrl, method }) {
    const initial = {};
    fields.forEach((f) => { initial[f.name] = item?.[f.name] ?? ''; });
    const { data, setData, post, put, processing, errors } = useForm(initial);
    const submit = (e) => {
        e.preventDefault();
        if (method === 'put') put(submitUrl);
        else post(submitUrl);
    };
    const field = 'mt-1 w-full rounded-md border border-slate-300 bg-white px-3 py-2';

    return (
        <Layout>
            <form onSubmit={submit} className="mx-auto max-w-md rounded-2xl bg-white p-6 shadow ring-1 ring-slate-200">
                <h2 className="font-serif text-2xl">{title}</h2>
                <div className="mt-4">
                    {fields.map((f) => (
                        <div key={f.name} className="mt-2">
                            <label className="text-sm text-slate-500">{f.label}</label>
                            <input type={f.type ?? 'text'} value={data[f.name] ?? ''} onChange={(e) => setData(f.name, e.target.value)} className={field} />
                            {errors[f.name] && <p className="text-sm text-red-600">{errors[f.name]}</p>}
                        </div>
                    ))}
                </div>
                <div className="mt-5 flex gap-3">
                    <button disabled={processing} className="rounded-lg bg-indigo-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-600">Save</button>
                    <Link href={back} className="rounded-lg px-4 py-2.5 text-sm text-slate-500 hover:underline">Back</Link>
                </div>
            </form>
        </Layout>
    );
}
