<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Item extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'category_id', 'status', 'building_id', 'room_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            // Generate code when item is being created
            $item->code = self::generateItemCode($item->category);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }
    public function transferTo($buildingId, $roomId)
    {
        $this->update([
            'building_id' => $buildingId,
            'room_id' => $roomId,
        ]);
    }

    // Make sure this method is static
    public static function generateItemCode($category)
    {
        $year = date('Y');
        $lastItem = self::where('category_id', $category->id)
                        ->whereYear('created_at', $year)
                        ->orderBy('id', 'desc')
                        ->first();
        
        $nextNumber = $lastItem ? ((int)substr($lastItem->code, -3)) + 1 : 1;
        return strtoupper($category->code) . "-$year-" . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
