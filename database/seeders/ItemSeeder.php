<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Laptop Dell XPS 13',
                'category' => 'LPT',
                'year' => 2024,
                'location_id' => 1, // Cabang Jakarta (Gudang)
            ],
            [
                'name' => 'Laptop Lenovo ThinkPad',
                'category' => 'LPT',
                'year' => 2024,
                'location_id' => 2, // Cabang Jakarta (Multimedia)
            ],
            [
                'name' => 'Proyektor Epson EB-X49',
                'category' => 'PRJ',
                'year' => 2024,
                'location_id' => 3, // Cabang Surabaya (Gudang)
            ],
            [
                'name' => 'Proyektor BenQ MW560',
                'category' => 'PRJ',
                'year' => 2024,
                'location_id' => 4, // Cabang Surabaya (Keuangan)
            ],
            [
                'name' => 'Meja Kerja Kayu',
                'category' => 'MJK',
                'year' => 2023,
                'location_id' => 1, // Cabang Jakarta (Gudang)
            ],
            [
                'name' => 'Printer HP LaserJet Pro',
                'category' => 'PRN',
                'year' => 2023,
                'location_id' => 2, // Cabang Jakarta (Multimedia)
            ],
        ];

        foreach ($items as $item) {
            // Hitung jumlah barang dalam kategori dan tahun yang sama
            $count = Item::where('category', $item['category'])
                         ->where('year', $item['year'])
                         ->count() + 1;

            // Format kode barang [Kategori]-[Tahun]-[Nomor Urut]
            $itemCode = strtoupper($item['category']) . '-' . $item['year'] . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

            // Simpan barang ke database
            Item::create([
                'name' => $item['name'],
                'category' => $item['category'],
                'year' => $item['year'],
                'location_id' => $item['location_id'],
                'code' => $itemCode,
            ]);
        }
    }
}
