<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimetableEntry;
use Illuminate\Http\Request;

class TimetableEntryController extends Controller
{
    public function index(Request $request)
    {
        $query = TimetableEntry::with(['schoolClass', 'subject', 'teacher', 'room'])
            ->orderBy('day_of_week')->orderBy('start_time');

        if ($request->filled('school_class_id')) {
            $query->where('school_class_id', $request->school_class_id);
        }
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }
        if ($request->filled('day_of_week')) {
            $query->where('day_of_week', $request->day_of_week);
        }

        $entries = $query->paginate(20)->withQueryString();
        $classes = SchoolClass::orderBy('name')->get();
        $teachers = Teacher::orderBy('name')->get();

        return view('timetable.index', compact('entries', 'classes', 'teachers'));
    }

    public function grid(Request $request)
    {
        $classId = $request->get('school_class_id');
        $classes = SchoolClass::orderBy('name')->get();
        $selectedClass = $classId ? SchoolClass::find($classId) : $classes->first();

        $entries = collect();
        if ($selectedClass) {
            $entries = TimetableEntry::with(['subject', 'teacher', 'room'])
                ->where('school_class_id', $selectedClass->id)
                ->orderBy('start_time')
                ->get()
                ->groupBy('day_of_week');
        }

        return view('timetable.grid', compact('classes', 'selectedClass', 'entries'));
    }

    public function create()
    {
        return view('timetable.create', [
            'classes' => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'teachers' => Teacher::orderBy('name')->get(),
            'rooms' => Room::orderBy('name')->get(),
            'days' => TimetableEntry::DAYS,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'day_of_week' => 'required|integer|min:1|max:7',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        if ($conflict = TimetableEntry::findConflict($data)) {
            return back()->withErrors(['conflict' => $conflict])->withInput();
        }

        TimetableEntry::create($data);
        return redirect()->route('timetable.index')->with('success', 'Timetable entry created.');
    }

    public function edit(TimetableEntry $timetable)
    {
        return view('timetable.edit', [
            'entry' => $timetable,
            'classes' => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'teachers' => Teacher::orderBy('name')->get(),
            'rooms' => Room::orderBy('name')->get(),
            'days' => TimetableEntry::DAYS,
        ]);
    }

    public function update(Request $request, TimetableEntry $timetable)
    {
        $data = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'day_of_week' => 'required|integer|min:1|max:7',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        if ($conflict = TimetableEntry::findConflict($data, $timetable->id)) {
            return back()->withErrors(['conflict' => $conflict])->withInput();
        }

        $timetable->update($data);
        return redirect()->route('timetable.index')->with('success', 'Timetable entry updated.');
    }

    public function destroy(TimetableEntry $timetable)
    {
        $timetable->delete();
        return redirect()->route('timetable.index')->with('success', 'Timetable entry deleted.');
    }
}
