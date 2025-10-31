<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of all items.
     */
    public function index(Request $request)
    {
        $query = Item::with(['weapon.damageType', 'armor', 'category', 'rarity']);
        $items = $this->applyFilters($request, $query)->paginate(15);

        return $this->renderItems($request, $items, 'items.index');
    }

    /**
     * Display SRD items only.
     */
    public function srdIndex(Request $request)
    {
        $query = Item::where('is_srd', true)
            ->with(['category', 'rarity', 'weapon.damageType', 'armor']);

        $items = $this->applyFilters($request, $query)->paginate(15);

        return $this->renderItems($request, $items, 'items.srd');
    }

    /**
     * Display custom items for the authenticated user.
     */
    public function customIndex(Request $request)
    {
        $query = Item::where('is_srd', false)
            ->where('user_id', auth()->id())
            ->with(['category', 'rarity', 'weapon.damageType', 'armor']);

        $items = $this->applyFilters($request, $query)->paginate(15);

        return $this->renderItems($request, $items, 'items.custom');
    }

    /**
     * Display a single item.
     */
    public function show(Item $item)
    {
        $item->load([
            'weapon.damageType',
            'armor',
            'category',
            'rarity',
            'baseItem.weapon.damageType',
            'baseItem.armor'
        ]);

        return view('items.show', compact('item'));
    }

    // Placeholder methods for future CRUD
    public function create() {}
    public function store(Request $request) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}

    /**
     * Apply search and filter parameters to the query.
     */
    private function applyFilters(Request $request, $query)
    {
        if ($search = $request->q) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($category = $request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $category));
        }

        if ($rarity = $request->rarity) {
            $query->whereHas('rarity', fn($q) => $q->where('slug', $rarity));
        }

        return $query;
    }

    /**
     * Render either the full view or just the results partial for AJAX.
     */
    private function renderItems(Request $request, $items, $view)
    {
        if ($request->ajax()) {
            return view('items.partials.results', compact('items'));
        }

        return view($view, compact('items'));
    }
}
