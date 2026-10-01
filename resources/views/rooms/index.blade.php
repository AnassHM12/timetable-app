@extends('layout')
@section('title', 'Rooms')
@section('content')
<div class="card"><h2>Rooms <a class="btn btn-primary" href="{{ route('rooms.create') }}">+ Add</a></h2>
<table><tr><th>Name</th><th>Capacity</th><th></th></tr>
@foreach($rooms as $r)<tr><td>{{ $r->name }}</td><td>{{ $r->capacity }}</td>
<td><a href="{{ route('rooms.edit',$r) }}">Edit</a> <form class="inline" method="POST" action="{{ route('rooms.destroy',$r) }}">@csrf @method('DELETE')<button style="color:red;background:none;border:0;cursor:pointer" onclick="return confirm('Delete?')">Del</button></form></td></tr>@endforeach</table>
<div class="pagination">{{ $rooms->links() }}</div></div>
@endsection
