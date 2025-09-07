<?php

namespace App\Http\Controllers;

use App\Models\Npc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NpcController extends Controller
{
    /**
     * Display a listing of the NPCs.
     */
    public function index()
    {
        $npcs = Npc::orderBy('name')->get();

        return view('npcs.index', compact('npcs'));
    }

    /**
     * Show the form for creating a new NPC.
     */
    public function create()
    {
        return view('npcs.create');
    }

    /**
     * Store a newly created NPC in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate incoming data including portrait file
        $data = $request->validate([
            'campaign_id'       => 'nullable|integer',
            'name'              => 'required|string|max:255',
            'alias'             => 'nullable|string|max:255',
            'race'              => 'nullable|string|max:255',
            'class'             => 'nullable|string|max:255',
            'role'              => 'nullable|string|max:255',
            'alignment'         => 'nullable|string|max:255',
            'location'          => 'nullable|string|max:255',
            'status'            => 'nullable|string|max:50',

            'portrait'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',

            'description'       => 'nullable|string',
            'personality'       => 'nullable|string',
            'quirks'            => 'nullable|string',

            'strength'          => 'nullable|integer|min:1|max:30',
            'dexterity'         => 'nullable|integer|min:1|max:30',
            'constitution'      => 'nullable|integer|min:1|max:30',
            'intelligence'      => 'nullable|integer|min:1|max:30',
            'wisdom'            => 'nullable|integer|min:1|max:30',
            'charisma'          => 'nullable|integer|min:1|max:30',
            'armor_class'       => 'nullable|integer|min:0|max:50',
            'hit_points'        => 'nullable|integer|min:0',
            'speed'             => 'nullable|string|max:50',
            'challenge_rating'  => 'nullable|string|max:10',
            'proficiency_bonus' => 'nullable|integer|min:0|max:10',
        ]);

        // 2. If a portrait file was uploaded, store it and record the public URL
        if ($request->hasFile('portrait')) {
            $path = $request->file('portrait')
                            ->store('npc-portraits', 'public');
            $data['portrait_path'] = '/storage/' . $path;
        }

        // 3. Mass‐create the NPC
        $npc = Npc::create($data);

        return redirect()
            ->route('npcs.show', $npc)
            ->with('success', 'NPC created successfully.');
    }

    /**
     * Display the specified NPC.
     */
    public function show(Npc $npc)
    {
        return view('npcs.show', compact('npc'));
    }

    /**
     * Show the form for editing the specified NPC.
     */
    public function edit(Npc $npc)
    {
        return view('npcs.edit', compact('npc'));
    }

    /**
     * Update the specified NPC in storage.
     */
    public function update(Request $request, Npc $npc)
    {
        // 1. Validate incoming data and check for remove flag
        $data = $request->validate([
            'campaign_id'       => 'nullable|integer',
            'name'              => 'required|string|max:255',
            'alias'             => 'nullable|string|max:255',
            'race'              => 'nullable|string|max:255',
            'class'             => 'nullable|string|max:255',
            'role'              => 'nullable|string|max:255',
            'alignment'         => 'nullable|string|max:255',
            'location'          => 'nullable|string|max:255',
            'status'            => 'nullable|string|max:50',

            'portrait'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'remove_portrait'   => 'sometimes|boolean',

            'description'       => 'nullable|string',
            'personality'       => 'nullable|string',
            'quirks'            => 'nullable|string',

            'strength'          => 'nullable|integer|min:1|max:30',
            'dexterity'         => 'nullable|integer|min:1|max:30',
            'constitution'      => 'nullable|integer|min:1|max:30',
            'intelligence'      => 'nullable|integer|min:1|max:30',
            'wisdom'            => 'nullable|integer|min:1|max:30',
            'charisma'          => 'nullable|integer|min:1|max:30',
            'armor_class'       => 'nullable|integer|min:0|max:50',
            'hit_points'        => 'nullable|integer|min:0',
            'speed'             => 'nullable|string|max:50',
            'challenge_rating'  => 'nullable|string|max:10',
            'proficiency_bonus' => 'nullable|integer|min:0|max:10',
        ]);

        // 2. If “remove_portrait” checked, delete the existing file & null out path
        if ($request->boolean('remove_portrait') && $npc->portrait_path) {
            Storage::disk('public')
                ->delete(str_replace('/storage/', '', $npc->portrait_path));
            $data['portrait_path'] = null;
        }

        // 3. If a new portrait was uploaded, delete old file and store the new one
        if ($request->hasFile('portrait')) {
            if ($npc->portrait_path) {
                Storage::disk('public')
                    ->delete(str_replace('/storage/', '', $npc->portrait_path));
            }
            $path = $request->file('portrait')
                            ->store('npc-portraits', 'public');
            $data['portrait_path'] = '/storage/' . $path;
        }

        // 4. Persist updates
        $npc->update($data);

        return redirect()
            ->route('npcs.show', $npc)
            ->with('success', 'NPC updated successfully.');
    }

    /**
     * Remove the specified NPC from storage.
     */
    public function destroy(Npc $npc)
    {
        // If a portrait exists, delete the file
        if ($npc->portrait_path) {
            Storage::disk('public')
                ->delete(str_replace('/storage/', '', $npc->portrait_path));
        }

        $npc->delete();

        return redirect()
            ->route('characters.index')
            ->with('success', 'NPC deleted successfully.');
    }
}
