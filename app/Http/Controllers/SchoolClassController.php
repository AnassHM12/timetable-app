<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SchoolClassController extends Controller
{
    public function index()
    {
        $p = SchoolClass::orderBy('name')->paginate(15);
        return Inertia::render('Classes', [
            'classes' => $p->items(),
            'meta' => ['current_page' => $p->currentPage(), 'last_page' => $p->lastPage()],
        ]);
    }

    public function create()
    {
        return Inertia::render('EntityForm', [
            'title' => 'Add class',
            'back' => route('classes.index'),
            'submitUrl' => route('classes.store'),
            'method' => 'post',
            'fields' => [
                ['name' => 'name', 'label' => 'Name (e.g. 10-A)'],
                ['name' => 'grade_level', 'label' => 'Grade level'],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:school_classes,name',
            'grade_level' => 'nullable|string|max:255',
        ]);
        SchoolClass::create($data);
        return redirect()->route('classes.index')->with('success', 'Class added.');
    }

    public function edit(SchoolClass $schoolClass)
    {
        return Inertia::render('EntityForm', [
            'title' => 'Edit class',
            'back' => route('classes.index'),
            'submitUrl' => route('classes.update', $schoolClass),
            'method' => 'put',
            'item' => $schoolClass->only('name', 'grade_level'),
            'fields' => [
                ['name' => 'name', 'label' => 'Name (e.g. 10-A)'],
                ['name' => 'grade_level', 'label' => 'Grade level'],
            ],
        ]);
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:school_classes,name,' . $schoolClass->id,
            'grade_level' => 'nullable|string|max:255',
        ]);
        $schoolClass->update($data);
        return redirect()->route('classes.index')->with('success', 'Class updated.');
    }

    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted.');
    }
}
