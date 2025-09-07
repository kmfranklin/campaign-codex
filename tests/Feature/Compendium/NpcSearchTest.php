<?php

namespace Tests\Feature\Compendium;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Npc;

class NpcSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_search_filters_npcs()
    {
        Npc::factory()->create(['name' => 'Gandalf']);
        Npc::factory()->create(['name' => 'Frodo']);

        $this->get('/compendium/npcs?q=Gandalf')
             ->assertStatus(200)
             ->assertSee('Gandalf')
             ->assertDontSee('Frodo');
    }
}
