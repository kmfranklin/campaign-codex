<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class LinkItemVariants extends Command
{
    protected $signature = 'items:link-variants';
    protected $description = 'Auto-link item variants to their base items';

    public function handle(): int
    {
        // Get category IDs for armor and weapons
        $armorCat = DB::table('item_categories')->where('slug', 'armor')->value ('id');
        $weaponCat = DB::table('item_categories')->where('slug', 'weapon')->value   ('id');

        // Only look at items in those categories that have parentheses in the name
        $variants = Item::whereIn('item_category_id', [$armorCat, $weaponCat])
            ->where('name', 'like', '%(%')
            ->get();

        $this->info("Found {$variants->count()} potential armor/weapon variants:");

        foreach ($variants as $variant) {
            $baseName = $this->extractBaseName($variant->name);

            if (!$baseName) {
                $this->warn("No base name extracted for: {$variant->name}");
                continue;
            }

            $normalized = $this->normalizeName($baseName);

            // Try to find a base item with a normalized name match
            $baseItem = Item::all()->first(function ($item) use ($normalized) {
                return $this->normalizeName($item->name) === $normalized;
            });

            if ($baseItem) {
                $variant->base_item_id = $baseItem->id;
                $variant->save();

                $this->info("Linked: {$variant->name} → {$baseItem->name}");
            } else {
                $this->warn("No match found for: {$variant->name} (normalized:      {$normalized})");
            }
        }

        return self::SUCCESS;
    }

    private function extractBaseName(string $name): ?string
    {
        // Look for parentheses
        if (preg_match('/\(([^)]+)\)/', $name, $matches)) {
            $inside = trim($matches[1]);

            // If inside is a bonus like +1, +2, +3 → base is the part before "("
            if (preg_match('/^\+\d+$/', $inside)) {
                return trim(substr($name, 0, strpos($name, '(')));
            }

            // Otherwise, treat the inside as the base item name
            return $inside;
        }

        return null;
    }

    private function normalizeName(string $name): string
    {
        return strtolower(
            preg_replace('/\s+/', ' ',
                str_replace('-', ' ', trim($name))
            )
        );
    }
}
