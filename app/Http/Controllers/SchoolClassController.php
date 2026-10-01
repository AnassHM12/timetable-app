<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::orderBy('name')->paginate(15);
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:school_classes,name',
            'grade_level' => 'nullable|string|max:255',
        ]);
        SchoolClass::create($data);
        return redirect()->route('classes.index')->with('success', 'Class created.');
    }

    public function edit(SchoolClass $schoolClass)
    {
        return view('classes.edit', ['class' => $schoolClass]);
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
