@extends('layout')
@section('title', 'Subjects')
@section('content')
<div class="card"><h2>Subjects <a class="btn btn-primary" href="{{ route('subjects.create') }}">+ Add</a></h2>
<table><tr><th>Name</th><th>Code</th><th></th></tr>
@foreach($subjects as $s)<tr><td>{{ $s->name }}</td><td>{{ $s->code }}</td>
<td><a href="{{ route('subjects.edit',$s) }}">Edit</a> <form class="inline" method="POST" action="{{ route('subjects.destroy',$s) }}">@csrf @method('DELETE')<button style="color:red;background:none;border:0;cursor:pointer" onclick="return confirm('Delete?')">Del</button></form></td></tr>@endforeach</table>
<div class="pagination">{{ $subjects->links() }}</div></div>
@endsection
