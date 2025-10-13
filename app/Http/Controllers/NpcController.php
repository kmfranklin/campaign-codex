<?php

namespace App\Http\Controllers;

use App\Models\Npc;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class NpcController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->npcs();

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('class')) {
            $query->where('class', $request->class);
        }

        if ($request->filled('alignment')) {
            $query->where('alignment', $request->alignment);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $npcs = $query
            ->orderBy('name')
            ->paginate(15)
            ->appends($request->only(['q', 'class', 'alignment', 'role']));

        return $request->ajax()
            ? view('compendium.npcs.partials.results', compact('npcs'))
            : view('compendium.npcs.index', compact('npcs'));
    }

    public function create()
    {
        return view('compendium.npcs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $this->handlePortraitUpload($request, $data);

        // Assign ownership automatically
        $npc = $request->user()->npcs()->create($data);

        return redirect()
            ->route('compendium.npcs.show', $npc)
            ->with('success', 'NPC created successfully.');
    }

    public function show(Request $request, $npcId)
    {
        $npc = $request->user()->npcs()->findOrFail($npcId);
        $quests = $npc->quests()->with('campaign')->get();
        return view('compendium.npcs.show', compact('npc', 'quests'));
    }

    public function edit(Request $request, $npcId)
    {
        $npc = $request->user()->npcs()->findOrFail($npcId);
        return view('compendium.npcs.edit', compact('npc'));
    }

    public function update(Request $request, $npcId)
    {
        $npc = $request->user()->npcs()->findOrFail($npcId);

        $data = $request->validate($this->rules(true));
        $this->handlePortraitUpload($request, $data, $npc);

        $npc->update($data);

        return redirect()
            ->route('compendium.npcs.show', $npc)
            ->with('success', 'NPC updated successfully.');
    }

    public function destroy(Request $request, $npcId)
    {
        $npc = $request->user()->npcs()->findOrFail($npcId);

        if ($npc->portrait_path) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $npc->portrait_path));
        }

        $npc->delete();

        return redirect()
            ->route('compendium.npcs.index')
            ->with('success', 'NPC deleted successfully.');
    }

    private function rules(bool $isUpdate = false): array
    {
        return [
            'campaign_id'       => 'nullable|integer',
            'name'              => 'required|string|max:255',
            'alias'             => 'nullable|string|max:255',
            'race'              => ['nullable', Rule::in(Npc::raceOptions())],
            'class'             => ['nullable', Rule::in(Npc::classOptions())],
            'role'              => ['nullable', Rule::in(Npc::socialRoleOptions())],
            'alignment'         => ['nullable', Rule::in(Npc::alignmentOptions())],
            'status'            => ['nullable', Rule::in(Npc::statusOptions())],
            'location'          => 'nullable|string|max:255',

            'portrait'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'remove_portrait'   => $isUpdate ? 'sometimes|boolean' : 'prohibited',

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
        ];
    }

    private function handlePortraitUpload(Request $request, array &$data, ?Npc $npc = null): void
    {
        if ($npc && $request->boolean('remove_portrait') && $npc->portrait_path) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $npc->portrait_path));
            $data['portrait_path'] = null;
        }

        if ($request->hasFile('portrait')) {
            if ($npc && $npc->portrait_path) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $npc->portrait_path));
            }
            $path = $request->file('portrait')->store('npc-portraits', 'public');
            $data['portrait_path'] = '/storage/' . $path;
        }
    }
}
