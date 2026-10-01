@extends('layout')
@section('title', 'Classes')
@section('content')
<div class="card"><h2>Classes <a class="btn btn-primary" href="{{ route('classes.create') }}">+ Add</a></h2>
<table><tr><th>Name</th><th>Grade</th><th></th></tr>
@foreach($classes as $c)<tr><td>{{ $c->name }}</td><td>{{ $c->grade_level }}</td>
<td><a href="{{ route('classes.edit',$c) }}">Edit</a> <form class="inline" method="POST" action="{{ route('classes.destroy',$c) }}">@csrf @method('DELETE')<button style="color:red;background:none;border:0;cursor:pointer" onclick="return confirm('Delete?')">Del</button></form></td></tr>@endforeach</table>
<div class="pagination">{{ $classes->links() }}</div></div>
@endsection
