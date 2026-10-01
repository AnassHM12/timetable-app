@extends('layout')
@section('title', isset($room)?'Edit Room':'Add Room')
@section('content')
<div class="card"><h2>{{ isset($room)?'Edit':'Add' }} Room</h2>
<form method="POST" action="{{ isset($room)?route('rooms.update',$room):route('rooms.store') }}">@csrf @if(isset($room))@method('PUT')@endif
<label>Name</label><input name="name" value="{{ old('name',$room->name??'') }}" required>
<label>Capacity</label><input name="capacity" type="number" min="1" value="{{ old('capacity',$room->capacity??'') }}">
<button class="btn btn-primary">Save</button></form></div>
@endsection
