<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimetableEntry;
use Illuminate\Database\Seeder;

class TimetableSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = collect(['Alice Smith', 'Bob Jones', 'Carol White'])->map(fn($n) => Teacher::firstOrCreate(['name' => $n]));
        $rooms = collect(['Room 101', 'Room 102', 'Lab A'])->map(fn($n) => Room::firstOrCreate(['name' => $n]));
        $classes = collect(['10-A', '10-B'])->map(fn($n) => SchoolClass::firstOrCreate(['name' => $n]));
        $math = Subject::firstOrCreate(['name' => 'Math'], ['code' => 'MTH']);
        $eng = Subject::firstOrCreate(['name' => 'English'], ['code' => 'ENG']);
        Subject::firstOrCreate(['name' => 'Physics'], ['code' => 'PHY']);

        if (TimetableEntry::count() === 0) {
            TimetableEntry::create([
                'school_class_id' => $classes[0]->id,
                'subject_id' => $math->id,
                'teacher_id' => $teachers[0]->id,
                'room_id' => $rooms[0]->id,
                'day_of_week' => 1,
                'start_time' => '08:00',
                'end_time' => '09:00',
            ]);
            TimetableEntry::create([
                'school_class_id' => $classes[0]->id,
                'subject_id' => $eng->id,
                'teacher_id' => $teachers[1]->id,
                'room_id' => $rooms[1]->id,
                'day_of_week' => 1,
                'start_time' => '09:00',
                'end_time' => '10:00',
            ]);
        }
    }
}
