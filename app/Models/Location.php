<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'room', 'floor', 'description'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function getFullLocationAttribute()
    {
        $parts = array_filter([$this->name, $this->room, $this->floor]);
        return implode(' - ', $parts);
    }
}
