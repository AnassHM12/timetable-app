# Timetable Manager (Laravel)

A simple school timetable management web app built with Laravel 12.
Manage classes, subjects, teachers, rooms, and weekly lessons with automatic conflict detection.

## Features

- Weekly grid view per class (Mon–Sun)
- Lesson CRUD with filters (class / teacher / day)
- CRUD for Classes, Subjects, Teachers, Rooms
- Conflict detection: blocks double-booking of the same teacher, room, or class on overlapping times
- SQLite by default — no MySQL setup needed
- Plain Blade + CSS — no Node/Vite build required

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
  TimetableEntry.php      # relations + findConflict() + DAYS constant
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
routes/web.php            # home grid + resource routes
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
same `day_of_week` + time overlap (`start < new_end AND end > new_start`) + same teacher OR same room OR same class → reject with message.

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

- Desktop app: Laravel is web-native. Run locally via `php artisan serve` and use in the browser. An installable desktop wrapper (Electron/Tauri) is out of scope for this repo.
- The included `database/database.sqlite` contains demo data. Delete it and re-run `migrate + db:seed` for a fresh start. It is git-ignored by default Laravel `.gitignore` except as local dev artifact — remove from `.gitignore` if you want to version it.
- Time format: `H:i` (e.g. `08:00`).
