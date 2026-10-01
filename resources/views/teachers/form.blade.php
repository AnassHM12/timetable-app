@extends('layout')
@section('title', isset($teacher)?'Edit Teacher':'Add Teacher')
@section('content')
<div class="card"><h2>{{ isset($teacher)?'Edit':'Add' }} Teacher</h2>
<form method="POST" action="{{ isset($teacher)?route('teachers.update',$teacher):route('teachers.store') }}">@csrf @if(isset($teacher))@method('PUT')@endif
<label>Name</label><input name="name" value="{{ old('name',$teacher->name??'') }}" required>
<label>Email</label><input name="email" type="email" value="{{ old('email',$teacher->email??'') }}">
<label>Phone</label><input name="phone" value="{{ old('phone',$teacher->phone??'') }}">
<button class="btn btn-primary">Save</button></form></div>
@endsection
