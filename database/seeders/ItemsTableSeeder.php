<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        $path = base_path('database/data/Item.json');
        $json = json_decode(file_get_contents($path), true);

        $items = collect($json)->map(function ($entry) {
            $fields = $entry['fields'];

            return [
                'key' => $entry['pk'],                           // unique key from JSON
                'name' => $fields['name'],
                'description' => $fields['desc'] ?? null,
                'cost' => $fields['cost'] ?? null,
                'weight' => $fields['weight'] ?? null,
                'is_magic_item' => $fields['is_magic_item'] ?? false,
                'requires_attunement' => $fields['requires_attunement'] ?? false,
                'attunement_requirements' => $fields['attunement'] ?? null,

                // Lookups: match slugs from JSON to reference tables
                'item_category_id' => DB::table('item_categories')
                    ->where('slug', $fields['category'] ?? null)
                    ->value('id'),

                'item_rarity_id' => DB::table('item_rarities')
                    ->where('slug', $fields['rarity'] ?? null)
                    ->value('id'),

                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->all();

        DB::table('items')->insert($items);
    }
}
