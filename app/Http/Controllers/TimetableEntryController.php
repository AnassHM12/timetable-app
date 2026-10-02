<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimetableEntry;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimetableEntryController extends Controller
{
    private function days(): array
    {
        return collect(TimetableEntry::DAYS)->map(fn ($name, $num) => ['num' => $num, 'name' => $name])->values()->all();
    }

    public function index(Request $request)
    {
        $query = TimetableEntry::with(['schoolClass', 'subject', 'teacher', 'room'])
            ->orderBy('day_of_week')->orderBy('start_time');

        if ($request->filled('school_class_id')) $query->where('school_class_id', $request->school_class_id);
        if ($request->filled('teacher_id')) $query->where('teacher_id', $request->teacher_id);
        if ($request->filled('day_of_week')) $query->where('day_of_week', $request->day_of_week);

        $p = $query->paginate(20)->withQueryString();

        return Inertia::render('Lessons', [
            'entries' => collect($p->items())->map(fn ($e) => [
                'id' => $e->id,
                'day' => $e->day_name,
                'start' => substr($e->start_time, 0, 5),
                'end' => substr($e->end_time, 0, 5),
                'class' => $e->schoolClass->name,
                'subject' => $e->subject->name,
                'subject_id' => $e->subject_id,
                'teacher' => $e->teacher->name,
                'room' => $e->room->name,
            ]),
            'meta' => ['current_page' => $p->currentPage(), 'last_page' => $p->lastPage()],
            'filters' => $request->only('school_class_id', 'teacher_id', 'day_of_week'),
            'filterOptions' => [
                'classes' => SchoolClass::orderBy('name')->get(['id', 'name']),
                'teachers' => Teacher::orderBy('name')->get(['id', 'name']),
            ],
            'days' => $this->days(),
        ]);
    }

    public function grid(Request $request)
    {
        $classes = SchoolClass::orderBy('name')->get(['id', 'name']);
        $selectedClass = $request->school_class_id
            ? SchoolClass::find($request->school_class_id)
            : $classes->first();

        $byDay = [];
        $lessons = 0;
        if ($selectedClass) {
            $entries = TimetableEntry::with(['subject', 'teacher', 'room'])
                ->where('school_class_id', $selectedClass->id)
                ->orderBy('start_time')->get();
            $lessons = $entries->count();
            foreach ($entries->groupBy('day_of_week') as $day => $list) {
                $byDay[$day] = $list->map(fn ($e) => [
                    'id' => $e->id,
                    'start' => substr($e->start_time, 0, 5),
                    'end' => substr($e->end_time, 0, 5),
                    'subject' => $e->subject->name,
                    'subject_id' => $e->subject_id,
                    'teacher' => $e->teacher->name,
                    'room' => $e->room->name,
                ])->all();
            }
        }

        return Inertia::render('Grid', [
            'classes' => $classes,
            'selectedClass' => $selectedClass?->only('id', 'name'),
            'days' => array_values(array_filter($this->days(), fn ($d) => $d['num'] <= 5)),
            'entriesByDay' => $byDay,
            'stats' => [
                'lessons' => $lessons,
                'teachers' => Teacher::count(),
                'rooms' => Room::count(),
            ],
        ]);
    }

    private function options(): array
    {
        return [
            'classes' => SchoolClass::orderBy('name')->get(['id', 'name']),
            'subjects' => Subject::orderBy('name')->get(['id', 'name']),
            'teachers' => Teacher::orderBy('name')->get(['id', 'name']),
            'rooms' => Room::orderBy('name')->get(['id', 'name']),
            'days' => $this->days(),
        ];
    }

    public function create()
    {
        return Inertia::render('LessonForm', $this->options());
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
        return redirect()->route('timetable.index')->with('success', 'Lesson added.');
    }

    public function edit(TimetableEntry $timetable)
    {
        return Inertia::render('LessonForm', array_merge($this->options(), [
            'entry' => $timetable->only(
                'id', 'school_class_id', 'subject_id', 'teacher_id',
                'room_id', 'day_of_week', 'start_time', 'end_time'
            ),
        ]));
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
        return redirect()->route('timetable.index')->with('success', 'Lesson updated.');
    }

    public function destroy(TimetableEntry $timetable)
    {
        $timetable->delete();
        return redirect()->route('timetable.index')->with('success', 'Lesson deleted.');
    }
}
