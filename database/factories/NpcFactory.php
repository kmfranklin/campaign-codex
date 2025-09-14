<?php

namespace Database\Factories;

use App\Models\Npc;
use Illuminate\Database\Eloquent\Factories\Factory;

class NpcFactory extends Factory
{
    protected $model = Npc::class;

    public function definition()
    {
        return [
            'name'              => $this->faker->name(),
            'role'              => $this->faker->randomElement(['Wizard', 'Ranger', 'Cleric', 'Rogue']),
            'alignment'         => $this->faker->randomElement(['Lawful Good', 'Chaotic Neutral', 'Neutral']),
            'location'          => $this->faker->city(),
            'status'            => $this->faker->randomElement(['Active', 'Retired', 'Deceased']),
            'campaign_id'       => null,
            'alias'             => $this->faker->optional()->userName(),
            'race'              => $this->faker->optional()->word(),
            'class'             => $this->faker->optional()->word(),
            'description'       => $this->faker->optional()->paragraph(),
        ];
    }
}
