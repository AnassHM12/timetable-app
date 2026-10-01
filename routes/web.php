<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TimetableEntryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TimetableEntryController::class, 'grid'])->name('home');

Route::resource('teachers', TeacherController::class)->except(['show']);
Route::resource('rooms', RoomController::class)->except(['show']);
Route::resource('subjects', SubjectController::class)->except(['show']);

Route::resource('classes', SchoolClassController::class)
    ->parameters(['classes' => 'schoolClass'])
    ->except(['show']);

Route::get('/timetable', [TimetableEntryController::class, 'index'])->name('timetable.index');
Route::get('/timetable/grid', [TimetableEntryController::class, 'grid'])->name('timetable.grid');
Route::get('/timetable/create', [TimetableEntryController::class, 'create'])->name('timetable.create');
Route::post('/timetable', [TimetableEntryController::class, 'store'])->name('timetable.store');
Route::get('/timetable/{timetable}/edit', [TimetableEntryController::class, 'edit'])->name('timetable.edit');
Route::put('/timetable/{timetable}', [TimetableEntryController::class, 'update'])->name('timetable.update');
Route::delete('/timetable/{timetable}', [TimetableEntryController::class, 'destroy'])->name('timetable.destroy');
