<?php

namespace Database\Factories;

use App\Models\Npc;
use Illuminate\Database\Eloquent\Factories\Factory;

class NpcFactory extends Factory
{
    protected $model = Npc::class;

    public function definition(): array
    {
        $roles      = ['Ally', 'Enemy', 'Neutral'];
        $alignments = [
            'Lawful Good', 'Neutral Good', 'Chaotic Good',
            'Lawful Neutral', 'Neutral', 'Chaotic Neutral',
            'Lawful Evil', 'Neutral Evil', 'Chaotic Evil'
        ];
        $statuses   = ['Active', 'Retired', 'Deceased'];
        $races      = ['Human', 'Elf', 'Dwarf', 'Dragonborn', 'Gnome', 'Halfling', 'Tiefling', 'Orc', 'Half‑Elf', 'Half‑Orc'];
        $classes    = ['Wizard', 'Ranger', 'Cleric', 'Rogue', 'Bard', 'Paladin', 'Druid', 'Fighter', 'Monk', 'Warlock', 'Sorcerer', 'Barbarian'];

        $firstNames = [
            'Elowen', 'Thrain', 'Seraphina', 'Borin', 'Lyra', 'Garrick', 'Fenwick', 'Isolde',
            'Kaelen', 'Merric', 'Ophelia', 'Roderic', 'Sylvara', 'Torbin', 'Alaric', 'Brynna',
            'Cedric', 'Dain', 'Eira', 'Faelan', 'Gwyneira', 'Hadrian', 'Ilyana', 'Jareth',
            'Korrin', 'Leofric', 'Maelis', 'Nerys', 'Orin', 'Peregrin', 'Quintus', 'Rowan',
            'Selene', 'Theron', 'Ulric', 'Veyra', 'Wystan', 'Xanthos', 'Ysolde', 'Zorion'
        ];

        $lastNames = [
            'Ironfist', 'Moonshadow', 'Stormborn', 'Oakenshield', 'Silverquill', 'Thornwhisper',
            'Brightspear', 'Duskwalker', 'Emberforge', 'Windrider', 'Shadowbane', 'Lightbringer',
            'Frostmantle', 'Starweaver', 'Grimward', 'Hollowbrook', 'Mistvale', 'Ravencrest',
            'Stonehelm', 'Sunstrider', 'Nightbloom', 'Ashenforge', 'Dawnwhisper', 'Blackthorn',
            'Firebrand', 'Goldenshield', 'Hawkwind', 'Ironwood', 'Stormrider', 'Winterborn'
        ];

        $locations = [
            'Mistvale', 'Ironhold Keep', 'Ravenmoor', 'Stormwatch Citadel', 'Ebonreach',
            'Silverfen', 'Thornhollow', 'Brightwater Port', 'Ashenford', 'Moonspire',
            'Frostglen', 'Shadowfen', 'Suncrest', 'Hollowmere', 'Stonegate', 'Windmere',
            'Driftwood Harbor', 'Blackpeak', 'Starfall Village', 'Grimspire', 'Oakheart',
            'Redhaven', 'Whispering Pines', 'Emberfall', 'Highcliff', 'Duskmire'
        ];

        $name = $this->faker->randomElement($firstNames) . ' ' . $this->faker->randomElement($lastNames);

        return [
            'name'        => $name,
            'role'        => $this->faker->randomElement($roles),
            'alignment'   => $this->faker->randomElement($alignments),
            'location'    => $this->faker->randomElement($locations),
            'status'      => $this->faker->randomElement($statuses),
            'campaign_id' => null,
            'alias'       => $this->faker->optional()->userName(),
            'race'        => $this->faker->randomElement($races),
            'class'       => $this->faker->randomElement($classes),
            'description' => $this->faker->optional()->paragraph(),
        ];
    }
}
