<?php

namespace Database\Seeders;

use App\Models\Shoes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = storage_path('data/shoes.json');
        $jsonContent = file_get_contents($filePath);
        $dataArray = json_decode($jsonContent, true);
        $data = $dataArray['shoes'];
        $lenData = sizeof($data);
        for($i = 0; $i < $lenData; $i++) {
            DB::table('shoes')->insert([
                'id' => $data[$i]['id'],
                'name' => $data[$i]['name'],
                'description' => $data[$i]['description'],
                'image' => $data[$i]['image'],
                'price' => $data[$i]['price'],
                'color' => $data[$i]['color'],
            ]);
        }
    }
}
