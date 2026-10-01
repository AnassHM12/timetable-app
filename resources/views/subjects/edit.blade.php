@extends('layout')
@section('title', 'Edit Subject')
@section('content')
@include('subjects.form', ['subject' => $subject])
@endsection
