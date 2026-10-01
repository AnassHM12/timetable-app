<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimetableEntry extends Model
{
    protected $fillable = [
        'school_class_id', 'subject_id', 'teacher_id', 'room_id',
        'day_of_week', 'start_time', 'end_time',
    ];

    public const DAYS = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function getDayNameAttribute(): string
    {
        return self::DAYS[$this->day_of_week] ?? 'Unknown';
    }

    /**
     * Check for conflicts: same day + overlapping time + same teacher/room/class.
     * Returns string message if conflict, null otherwise.
     */
    public static function findConflict(array $data, ?int $ignoreId = null): ?string
    {
        $query = self::where('day_of_week', $data['day_of_week'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time']);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $overlapping = $query->get();

        foreach ($overlapping as $entry) {
            if ((int) $entry->teacher_id === (int) $data['teacher_id']) {
                return "Teacher is already booked on {$entry->day_name} {$entry->start_time}-{$entry->end_time} (Class: {$entry->schoolClass->name}).";
            }
            if ((int) $entry->room_id === (int) $data['room_id']) {
                return "Room {$entry->room->name} is already booked on {$entry->day_name} {$entry->start_time}-{$entry->end_time}.";
            }
            if ((int) $entry->school_class_id === (int) $data['school_class_id']) {
                return "Class {$entry->schoolClass->name} already has a lesson on {$entry->day_name} {$entry->start_time}-{$entry->end_time}.";
            }
        }

        return null;
    }
}
