@extends('layout')
@section('title', isset($entry)?'Edit Lesson':'Add Lesson')
@section('content')
<div class="card">
<h2>{{ isset($entry)?'Edit':'Add' }} Lesson</h2>
<form method="POST" action="{{ isset($entry)?route('timetable.update',$entry):route('timetable.store') }}">
@csrf @if(isset($entry))@method('PUT')@endif
<label>Class</label><select name="school_class_id">@foreach($classes as $c)<option value="{{ $c->id }}" {{ old('school_class_id', $entry->school_class_id??'')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select>
<label>Subject</label><select name="subject_id">@foreach($subjects as $s)<option value="{{ $s->id }}" {{ old('subject_id', $entry->subject_id??'')==$s->id?'selected':'' }}>{{ $s->name }}</option>@endforeach</select>
<label>Teacher</label><select name="teacher_id">@foreach($teachers as $t)<option value="{{ $t->id }}" {{ old('teacher_id', $entry->teacher_id??'')==$t->id?'selected':'' }}>{{ $t->name }}</option>@endforeach</select>
<label>Room</label><select name="room_id">@foreach($rooms as $r)<option value="{{ $r->id }}" {{ old('room_id', $entry->room_id??'')==$r->id?'selected':'' }}>{{ $r->name }}</option>@endforeach</select>
<label>Day</label><select name="day_of_week">@foreach($days as $n=>$d)<option value="{{ $n }}" {{ old('day_of_week', $entry->day_of_week??1)==$n?'selected':'' }}>{{ $d }}</option>@endforeach</select>
<label>Start</label><input type="time" name="start_time" value="{{ old('start_time', isset($entry)?substr($entry->start_time,0,5):'08:00') }}">
<label>End</label><input type="time" name="end_time" value="{{ old('end_time', isset($entry)?substr($entry->end_time,0,5):'09:00') }}">
<button class="btn btn-primary">Save</button> <a class="btn btn-secondary" href="{{ route('timetable.index') }}">Back</a>
</form>
</div>
@endsection
