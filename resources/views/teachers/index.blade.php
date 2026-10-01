@extends('layout')
@section('title', 'Teachers')
@section('content')
<div class="card"><h2>Teachers <a class="btn btn-primary" href="{{ route('teachers.create') }}">+ Add</a></h2>
<table><tr><th>Name</th><th>Email</th><th>Phone</th><th></th></tr>
@foreach($teachers as $t)<tr><td>{{ $t->name }}</td><td>{{ $t->email }}</td><td>{{ $t->phone }}</td>
<td><a href="{{ route('teachers.edit',$t) }}">Edit</a> <form class="inline" method="POST" action="{{ route('teachers.destroy',$t) }}">@csrf @method('DELETE')<button style="color:red;background:none;border:0;cursor:pointer" onclick="return confirm('Delete?')">Del</button></form></td></tr>@endforeach</table>
<div class="pagination">{{ $teachers->links() }}</div></div>
@endsection
