# Timetable Manager (Laravel)

A simple school timetable web app built with Laravel 12. You manage classes, subjects, teachers and rooms, then lay out weekly lessons on a grid. If two lessons clash, the app tells you and refuses to save.

## Features

- Weekly grid view per class (Monday to Sunday)
- Lesson list with filters by class, teacher and day
- Full CRUD for classes, subjects, teachers and rooms
- Conflict detection: no double booking the same teacher, room or class in overlapping times
- SQLite out of the box, so no MySQL setup needed
- Plain Blade templates and CSS, no Node build step

## Tech Stack

- PHP 8.2+ (tested with XAMPP PHP 8.2.12)
- Laravel 12
- SQLite (file: `database/database.sqlite`)
- Blade templates

## Quick Start

```powershell
# 1. Make PHP + Composer available (Windows/XAMPP example)
$env:Path += ";C:\xampp\php;C:\ProgramData\ComposerSetup\bin"

cd timetable-app

# 2. Install dependencies (already done in this repo snapshot, but safe to re-run)
composer install
cp .env.example .env   # if .env missing
php artisan key:generate  # if APP_KEY empty

# 3. Database
php artisan migrate --force
php artisan db:seed --force   # demo data: 3 teachers, 3 rooms, 2 classes, 3 subjects, 3 lessons

# 4. Run
php artisan serve
# open http://127.0.0.1:8000
```

## Project Structure

```
app/Models/
  Teacher.php, Room.php, SchoolClass.php, Subject.php
  TimetableEntry.php      # relations plus findConflict() plus DAYS constant
app/Http/Controllers/
  TeacherController.php, RoomController.php, SchoolClassController.php
  SubjectController.php, TimetableEntryController.php
database/migrations/
  2026_10_01_000001_create_teachers_table.php
  2026_10_01_000002_create_rooms_table.php
  2026_10_01_000003_create_school_classes_table.php
  2026_10_01_000004_create_subjects_table.php
  2026_10_01_000005_create_timetable_entries_table.php
database/seeders/TimetableSeeder.php
routes/web.php            # home grid plus resource routes
resources/views/
  layout.blade.php
  timetable/grid|index|create|edit|form.blade.php
  teachers|rooms|classes|subjects/{index,create,edit,form}.blade.php
```

## Data Model

- `teachers(id, name, email, phone)`
- `rooms(id, name, capacity)`
- `school_classes(id, name, grade_level)`
- `subjects(id, name, code)`
- `timetable_entries(id, school_class_id, subject_id, teacher_id, room_id, day_of_week 1-7, start_time, end_time)`

Conflict rule (`TimetableEntry::findConflict()`):
same `day_of_week` with overlapping times (`start < new_end AND end > new_start`) and the same teacher, room or class means a conflict, and the save is rejected with a message saying what clashes.

## Routes

| Method | URI | Name |
|---|---|---|
| GET | `/` | home (grid) |
| GET | `/timetable/grid` | timetable.grid |
| GET | `/timetable` | timetable.index |
| GET/POST | `/timetable/create`, `/timetable` | timetable.create/store |
| GET/PUT/DELETE | `/timetable/{timetable}/edit`, `/timetable/{timetable}` | timetable.edit/update/destroy |
| Resource | `/teachers`, `/rooms`, `/subjects`, `/classes` | standard index/create/store/edit/update/destroy |

## Notes

- This is a web app. Run it locally with `php artisan serve` and use it in the browser.
- Starting fresh: delete `database/database.sqlite` and re-run `migrate` plus `db:seed`.
- Time format is `H:i` (for example `08:00`).
