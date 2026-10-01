@extends('layout')
@section('title', 'Edit Lesson')
@section('content')
@include('timetable.form', ['entry' => $entry])
@endsection
