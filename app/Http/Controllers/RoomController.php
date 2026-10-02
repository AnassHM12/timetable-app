<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function index()
    {
        $p = Room::orderBy('name')->paginate(15);
        return Inertia::render('Rooms', [
            'rooms' => $p->items(),
            'meta' => ['current_page' => $p->currentPage(), 'last_page' => $p->lastPage()],
        ]);
    }

    public function create()
    {
        return Inertia::render('EntityForm', [
            'title' => 'Add room',
            'back' => route('rooms.index'),
            'submitUrl' => route('rooms.store'),
            'method' => 'post',
            'fields' => [
                ['name' => 'name', 'label' => 'Name'],
                ['name' => 'capacity', 'label' => 'Capacity', 'type' => 'number'],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name',
            'capacity' => 'nullable|integer|min:1',
        ]);
        Room::create($data);
        return redirect()->route('rooms.index')->with('success', 'Room added.');
    }

    public function edit(Room $room)
    {
        return Inertia::render('EntityForm', [
            'title' => 'Edit room',
            'back' => route('rooms.index'),
            'submitUrl' => route('rooms.update', $room),
            'method' => 'put',
            'item' => $room->only('name', 'capacity'),
            'fields' => [
                ['name' => 'name', 'label' => 'Name'],
                ['name' => 'capacity', 'label' => 'Capacity', 'type' => 'number'],
            ],
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name,' . $room->id,
            'capacity' => 'nullable|integer|min:1',
        ]);
        $room->update($data);
        return redirect()->route('rooms.index')->with('success', 'Room updated.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted.');
    }
}
