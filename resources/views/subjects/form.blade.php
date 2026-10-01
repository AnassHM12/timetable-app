@extends('layout')
@section('title', isset($subject)?'Edit Subject':'Add Subject')
@section('content')
<div class="card"><h2>{{ isset($subject)?'Edit':'Add' }} Subject</h2>
<form method="POST" action="{{ isset($subject)?route('subjects.update',$subject):route('subjects.store') }}">@csrf @if(isset($subject))@method('PUT')@endif
<label>Name</label><input name="name" value="{{ old('name',$subject->name??'') }}" required>
<label>Code</label><input name="code" value="{{ old('code',$subject->code??'') }}">
<button class="btn btn-primary">Save</button></form></div>
@endsection
