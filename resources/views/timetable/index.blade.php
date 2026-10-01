@extends('layout')
@section('title', 'All Lessons')
@section('content')
<div class="card">
<h2>Lessons <a class="btn btn-primary" href="{{ route('timetable.create') }}">+ Add</a></h2>
<form method="GET" class="filters">
<select name="school_class_id"><option value="">All classes</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('school_class_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select>
<select name="teacher_id"><option value="">All teachers</option>@foreach($teachers as $t)<option value="{{ $t->id }}" {{ request('teacher_id')==$t->id?'selected':'' }}>{{ $t->name }}</option>@endforeach</select>
<select name="day_of_week"><option value="">All days</option>@foreach(\App\Models\TimetableEntry::DAYS as $n=>$d)<option value="{{ $n }}" {{ request('day_of_week')==$n?'selected':'' }}>{{ $d }}</option>@endforeach</select>
<button class="btn btn-secondary">Filter</button>
</form>
<table><tr><th>Day</th><th>Time</th><th>Class</th><th>Subject</th><th>Teacher</th><th>Room</th><th></th></tr>
@foreach($entries as $e)
<tr><td>{{ $e->day_name }}</td><td>{{ substr($e->start_time,0,5) }}-{{ substr($e->end_time,0,5) }}</td><td>{{ $e->schoolClass->name }}</td><td>{{ $e->subject->name }}</td><td>{{ $e->teacher->name }}</td><td>{{ $e->room->name }}</td>
<td><a href="{{ route('timetable.edit',$e) }}">Edit</a> <form class="inline" method="POST" action="{{ route('timetable.destroy',$e) }}">@csrf @method('DELETE')<button style="color:red;background:none;border:0;cursor:pointer" onclick="return confirm('Delete?')">Del</button></form></td></tr>
@endforeach</table>
<div class="pagination">{{ $entries->links() }}</div>
</div>
@endsection
