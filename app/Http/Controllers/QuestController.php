<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Quest;
use App\Models\Npc;

class QuestController extends Controller
{
    /**
     * Display a listing of the quests for a campaign.
     */
    public function index(Campaign $campaign)
    {
        $quests = $campaign->quests()->latest()->get();

        return view('quests.index', compact('campaign', 'quests'));
    }

    /**
     * Show the form for creating a new quest.
     */
    public function create(Campaign $campaign)
    {
        return view('quests.create', compact('campaign'));
    }

    /**
     * Store a newly created quest in storage.
     */
    public function store(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planned,active,completed',
        ]);

        $campaign->quests()->create($validated);

        return redirect()
            ->route('campaigns.show', $campaign)
            ->with('success', 'Quest created successfully.');
    }

    /**
     * Display the specified quest.
     */
    public function show(Campaign $campaign, Quest $quest)
    {
        $attachedIds = $quest->npcs()->pluck('npcs.id');
        $availableNpcs = Npc::whereNotIn('id', $attachedIds)->orderBy('name')->get();

        return view('quests.show', compact('campaign', 'quest', 'availableNpcs'));
    }

    /**
     * Show the form for editing the specified quest.
     */
    public function edit(Campaign $campaign, Quest $quest)
    {
        return view('quests.edit', compact('campaign', 'quest'));
    }

    /**
     * Update the specified quest in storage.
     */
    public function update(Request $request, Campaign $campaign, Quest $quest)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planned,active,completed',
        ]);

        $quest->update($validated);

        return redirect()
            ->route('campaigns.quests.show', [$campaign, $quest])
            ->with('success', 'Quest updated successfully.');
    }

    /**
     * Remove the specified quest from storage.
     */
    public function destroy(Campaign $campaign, Quest $quest)
    {
        $quest->delete();

        return redirect()
            ->route('campaigns.show', $campaign)
            ->with('success', 'Quest deleted successfully.');
    }

    /**
     * Attach NPC to quest.
     */
    public function attachNpc(Request $request, Campaign $campaign, Quest $quest)
    {
        $this->authorize('update', $campaign);

        $validated = $request->validate([
            'npc_id' => ['required', 'exists:npc,id'],
            'role'   => ['nullable', 'string', 'max:50'],
        ]);

        $quest->npcs()->syncWithoutDetaching([
            $validated['npc_id'] => ['role' => $validated['role'] ?? null],
        ]);

        return redirect()
            ->route('campaigns.quest.show', [$campaign, $quest])
            ->with('success', 'NPC linked to quest.');
    }
}
