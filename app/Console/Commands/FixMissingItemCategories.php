<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use App\Models\ItemCategory;

class FixMissingItemCategories extends Command
{
    protected $signature = 'fix:missing-item-categories {--dry : Preview changes without saving} {--log= : Path to log file}';
    protected $description = 'Assign Weapon or Armor category to items based on type';

    public function handle()
    {
    $weaponCategoryId = ItemCategory::where('name', 'Weapon')->value('id');
    $armorCategoryId  = ItemCategory::where('name', 'Armor')->value('id');

    if (!$weaponCategoryId || !$armorCategoryId) {
        $this->error('Weapon or Armor category not found. Aborting.');
        return;
    }

    $dryRun = $this->option('dry');
    $logPath = $this->option('log');

    $items = Item::with(['weapon', 'armor'])
        ->whereNull('item_category_id')
        ->get();

    $this->info("Found {$items->count()} items missing category...");

    $logLines = [];

    $items->each(function ($item) use ($weaponCategoryId, $armorCategoryId, $dryRun, &$logLines) {
        $categoryId = null;
        $type = null;

        if ($item->weapon) {
            $categoryId = $weaponCategoryId;
            $type = 'Weapon';
        } elseif ($item->armor) {
            $categoryId = $armorCategoryId;
            $type = 'Armor';
        }

        if ($categoryId) {
            $logLines[] = "✔ {$item->name} → inferred type: {$type}, assigned category_id: {$categoryId}";

            if (!$dryRun) {
                $item->item_category_id = $categoryId;
                $item->save();
            }
        }
    });

    foreach ($logLines as $line) {
        $this->line($line);
    }

    if ($logPath) {
        file_put_contents($logPath, implode(PHP_EOL, $logLines));
        $this->info("Log written to: {$logPath}");
    }

    $this->info($dryRun ? 'Dry run complete.' : 'Update complete.');
    }
}
