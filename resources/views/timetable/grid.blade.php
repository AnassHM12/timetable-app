@extends('layout')
@section('title', 'Weekly Grid')
@section('content')
<div class="card">
<h2>Weekly Timetable Grid</h2>
<form method="GET" action="{{ route('timetable.grid') }}" class="filters">
<select name="school_class_id" onchange="this.form.submit()">
@foreach($classes as $c)
<option value="{{ $c->id }}" {{ $selectedClass && $selectedClass->id==$c->id?'selected':'' }}>{{ $c->name }}</option>
@endforeach
</select>
<a class="btn btn-primary" href="{{ route('timetable.create') }}">+ Add Lesson</a>
</form>
@if(!$selectedClass)<p>No classes yet. <a href="{{ route('classes.create') }}">Create one</a>.</p>
@else
<div class="grid-days">
@foreach(\App\Models\TimetableEntry::DAYS as $num=>$day)
<div class="day-col"><strong>{{ $day }}</strong><hr>
@forelse($entries->get($num, []) as $e)
<div class="lesson"><strong>{{ substr($e->start_time,0,5) }}-{{ substr($e->end_time,0,5) }}</strong><br>{{ $e->subject->name }}<br><small>{{ $e->teacher->name }} · {{ $e->room->name }}</small></div>
@empty
<small style="color:#94a3b8">—</small>
@endforelse
</div>
@endforeach
</div>
@endif
</div>
@endsection
