<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherController extends Controller
{
    public function index()
    {
        $p = Teacher::orderBy('name')->paginate(15);
        return Inertia::render('Teachers', [
            'teachers' => $p->items(),
            'meta' => ['current_page' => $p->currentPage(), 'last_page' => $p->lastPage()],
        ]);
    }

    public function create()
    {
        return Inertia::render('EntityForm', [
            'title' => 'Add teacher',
            'back' => route('teachers.index'),
            'submitUrl' => route('teachers.store'),
            'method' => 'post',
            'fields' => [
                ['name' => 'name', 'label' => 'Name'],
                ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
                ['name' => 'phone', 'label' => 'Phone'],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:teachers,email',
            'phone' => 'nullable|string|max:50',
        ]);
        Teacher::create($data);
        return redirect()->route('teachers.index')->with('success', 'Teacher added.');
    }

    public function edit(Teacher $teacher)
    {
        return Inertia::render('EntityForm', [
            'title' => 'Edit teacher',
            'back' => route('teachers.index'),
            'submitUrl' => route('teachers.update', $teacher),
            'method' => 'put',
            'item' => $teacher->only('name', 'email', 'phone'),
            'fields' => [
                ['name' => 'name', 'label' => 'Name'],
                ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
                ['name' => 'phone', 'label' => 'Phone'],
            ],
        ]);
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:teachers,email,' . $teacher->id,
            'phone' => 'nullable|string|max:50',
        ]);
        $teacher->update($data);
        return redirect()->route('teachers.index')->with('success', 'Teacher updated.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted.');
    }
}
