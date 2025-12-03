<?php

use Illuminate\Support\Facades\DB;
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
        // Seed roles if not already seeded
        DB::table('roles')->insertOrIgnore([
            ['id' => 1, 'name' => 'dm', 'description' => 'Dungeon Master'],
            ['id' => 2, 'name' => 'player', 'description' => 'Campaign Player'],
        ]);

        // Backfill campaign_user for existing campaigns
        $dmRoleId = DB::table('roles')->where('name', 'dm')->value('id');

        $campaigns = DB::table('campaigns')->get();
        foreach ($campaigns as $campaign) {
            DB::table('campaign_user')->insertOrIgnore([
                'campaign_id' => $campaign->id,
                'user_id'     => $campaign->dm_id,
                'role_id'     => $dmRoleId,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('campaign_user')->truncate();
    }
};
