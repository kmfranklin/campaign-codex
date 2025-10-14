<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeaponsTableSeeder extends Seeder
{
    public function run(): void
    {
        $path = base_path('database/data/Weapon.json');
        $json = json_decode(file_get_contents($path), true);

        $weapons = collect($json)->map(function ($entry) {
            $fields = $entry['fields'];

            return [
                // Link back to parent item by pk
                'item_id' => DB::table('items')
                    ->where('item_key', $entry['pk'])
                    ->value('id'),

                'damage_dice' => $fields['damage_dice'] ?? null,
                'damage_type_id' => DB::table('damage_types')
                    ->where('slug', $fields['damage_type'] ?? null)
                    ->value('id'),

                'range' => $fields['range'] ?? null,
                'long_range' => $fields['long_range'] ?? null,
                'distance_unit' => $fields['distance_unit'] ?? null,

                'is_improvised' => $fields['is_improvised'] ?? false,
                'is_simple' => $fields['is_simple'] ?? false,

                'created_at' => now(),
                'updated_at' => now(),
            ];
        })
        ->filter(fn ($weapon) => $weapon['item_id'] !== null) // skip if no parent item
        ->all();

        DB::table('weapons')->insert($weapons);
    }
}
