@extends('layout')
@section('title', 'Edit Teacher')
@section('content')
@include('teachers.form', ['teacher' => $teacher])
@endsection
