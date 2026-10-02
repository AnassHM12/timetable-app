<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubjectController extends Controller
{
    public function index()
    {
        $p = Subject::orderBy('name')->paginate(15);
        return Inertia::render('Subjects', [
            'subjects' => $p->items(),
            'meta' => ['current_page' => $p->currentPage(), 'last_page' => $p->lastPage()],
        ]);
    }

    public function create()
    {
        return Inertia::render('EntityForm', [
            'title' => 'Add subject',
            'back' => route('subjects.index'),
            'submitUrl' => route('subjects.store'),
            'method' => 'post',
            'fields' => [
                ['name' => 'name', 'label' => 'Name'],
                ['name' => 'code', 'label' => 'Code'],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:subjects,code',
        ]);
        Subject::create($data);
        return redirect()->route('subjects.index')->with('success', 'Subject added.');
    }

    public function edit(Subject $subject)
    {
        return Inertia::render('EntityForm', [
            'title' => 'Edit subject',
            'back' => route('subjects.index'),
            'submitUrl' => route('subjects.update', $subject),
            'method' => 'put',
            'item' => $subject->only('name', 'code'),
            'fields' => [
                ['name' => 'name', 'label' => 'Name'],
                ['name' => 'code', 'label' => 'Code'],
            ],
        ]);
    }

    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:subjects,code,' . $subject->id,
        ]);
        $subject->update($data);
        return redirect()->route('subjects.index')->with('success', 'Subject updated.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted.');
    }
}
