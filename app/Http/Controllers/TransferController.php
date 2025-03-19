<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Building;
use App\Models\Room;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TransferController extends Controller
{
    
    public function edit($id)
    {
        $id = Crypt::decrypt($id);

        $item = Item::findOrFail($id);

        $buildings = Building::with('rooms')->get();

        return view('admin.transfer.edit', compact('item', 'buildings'));
    }
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);

        $item = Item::findOrFail($id);

        $request->validate([
            'to_building_id' => 'required|exists:buildings,id',
            'to_room_id' => 'required|exists:rooms,id',
        ]);

        Transfer::create([
            'item_id' => $item->id,
            'from_building_id' => $item->building_id,
            'from_room_id' => $item->room_id,
            'to_building_id' => $request->to_building_id,
            'to_room_id' => $request->to_room_id,
            'status' => 'dalam proses', 
        ]);

        $item->update([
            'building_id' => $request->to_building_id,
            'room_id' => $request->to_room_id,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dipindahkan.');
    }
    public function getRoomsByBuilding($buildingId)
    {
        $rooms = Room::where('building_id', $buildingId)->get();
        return response()->json(['rooms' => $rooms]);
    }
        
    public function showHistory($id)
    {
        $itemId = Crypt::decrypt($id);
        $item = Item::findOrFail($itemId);

        $transfers = Transfer::where('item_id', $itemId)->get();

        return view('admin.barang.historytransfer', compact('item', 'transfers'));
    }
    public function history()
    {
        $transfers = Transfer::with('item', 'fromBuilding', 'fromRoom', 'toBuilding', 'toRoom')->get();

        return view('admin.transfer.history', compact('transfers'));
    }

}
