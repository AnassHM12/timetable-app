@extends('layout')
@section('title', 'Edit Room')
@section('content')
@include('rooms.form', ['room' => $room])
@endsection
