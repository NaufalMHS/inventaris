<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            
            // Menambahkan foreign key untuk from_building_id dan from_room_id
            $table->foreignId('from_building_id')->nullable()->constrained('buildings')->onDelete('set null');
            $table->foreignId('from_room_id')->nullable()->constrained('rooms')->onDelete('set null');
            
            // Menambahkan foreign key untuk to_building_id dan to_room_id
            $table->foreignId('to_building_id')->nullable()->constrained('buildings')->onDelete('set null');
            $table->foreignId('to_room_id')->nullable()->constrained('rooms')->onDelete('set null');
            
            // Status transfer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
