<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'from_building_id', 'from_room_id', 'to_building_id', 'to_room_id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function fromBuilding()
    {
        return $this->belongsTo(Building::class, 'from_building_id');
    }

    public function fromRoom()
    {
        return $this->belongsTo(Room::class, 'from_room_id');
    }

    public function toBuilding()
    {
        return $this->belongsTo(Building::class, 'to_building_id');
    }

    public function toRoom()
    {
        return $this->belongsTo(Room::class, 'to_room_id');
    }
}
