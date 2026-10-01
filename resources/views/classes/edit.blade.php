@extends('layout')
@section('title', 'Edit Class')
@section('content')
@include('classes.form', ['class' => $class])
@endsection
