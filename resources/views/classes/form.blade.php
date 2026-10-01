@extends('layout')
@section('title', isset($class)?'Edit Class':'Add Class')
@section('content')
<div class="card"><h2>{{ isset($class)?'Edit':'Add' }} Class</h2>
<form method="POST" action="{{ isset($class)?route('classes.update',$class):route('classes.store') }}">@csrf @if(isset($class))@method('PUT')@endif
<label>Name (e.g. 10-A)</label><input name="name" value="{{ old('name',$class->name??'') }}" required>
<label>Grade Level</label><input name="grade_level" value="{{ old('grade_level',$class->grade_level??'') }}">
<button class="btn btn-primary">Save</button></form></div>
@endsection
