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
            $this->line("- {$variant->name}");
        }

        return self::SUCCESS;
    }
}
