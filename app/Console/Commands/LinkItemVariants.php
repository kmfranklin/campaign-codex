<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;

class LinkItemVariants extends Command
{
    protected $signature = 'items:link-variants';
    protected $description = 'Auto-link item variants to their base items';

    public function handle(): int
    {
        $this->info("Linking item variants to their base armor/weapon...");

        // Key all items by their SRD key
        $allItems = Item::all()->keyBy('item_key');

        $linked = 0;
        $unlinked = 0;

        foreach (Item::all() as $item) {
            // Use the armor_key or weapon_key columns populated from JSON
            $baseKey = $item->armor_key ?? $item->weapon_key ?? null;

            if ($baseKey && isset($allItems[$baseKey])) {
                $baseItem = $allItems[$baseKey];

                $item->base_item_id = $baseItem->id;
                $item->save();

                $this->info("Linked: {$item->name} → {$baseItem->name}");
                $linked++;
            } else {
                $this->warn("No base link for: {$item->name}");
                $unlinked++;
            }
        }

        $this->info("Done. Linked {$linked} items, {$unlinked} unlinked.");
        return self::SUCCESS;
    }
}
