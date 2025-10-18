@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    {{-- Back link --}}
    <a href="{{ route('items.index') }}"
       class="inline-flex items-center text-sm text-purple-800 hover:text-purple-900 mb-4 font-medium">
      <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 19l-7-7 7-7"/>
      </svg>
      Back to Items
    </a>

    <div class="bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center mb-6 relative">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $item->name }}</h1>

                    {{-- tags --}}
                    @php
                        $tags = collect();
                        if ($item->category) $tags->push(['label' => $item->category->name, 'color' => 'purple']);
                        if ($item->rarity) $tags->push(['label' => $item->rarity->name, 'color' => 'indigo']);
                        $isWeapon = $item->weapon || $item->baseItem?->weapon;
                        $isArmor  = $item->armor || $item->baseItem?->armor;
                        if ($isWeapon) $tags->push(['label' => 'Weapon', 'color' => 'blue']);
                        if ($isArmor) $tags->push(['label' => 'Armor', 'color' => 'green']);
                        $tags = $tags->unique('label');
                    @endphp

                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <span class="bg-{{ $tag['color'] }}-50 text-{{ $tag['color'] }}-700 text-xs font-medium px-2 py-1 rounded">
                                {{ $tag['label'] }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- VARIANT BADGE (top-right corner) --}}
                @if($item->baseItem)
                    <div class="absolute top-0 right-0 mt-2 mr-2">
                        <a href="{{ route('items.show', $item->baseItem) }}"
                           class="inline-flex items-center text-xs px-2 py-1 rounded bg-purple-100 text-purple-700 hover:bg-purple-200">
                            Variant of {{ $item->baseItem->name }}
                        </a>
                    </div>
                @endif
            </div>
            {{-- /HEADER --}}

            {{-- DESCRIPTION --}}
            @if($item->description)
                <div class="mb-6 prose max-w-none">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Description</h2>
                    {!! Str::markdown($item->description) !!}
                </div>
            @endif

            {{-- DETAILS --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Details</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    @if($item->cost && $item->cost > 0)
                        <div>
                            <dt class="font-medium text-gray-600">Cost</dt>
                            <dd class="text-gray-800">
                                {{ rtrim(rtrim(number_format($item->cost, 2, '.', ''), '0'), '.') }} GP
                            </dd>
                        </div>
                    @endif
                    @if($item->weight && $item->weight > 0)
                        <div>
                            <dt class="font-medium text-gray-600">Weight</dt>
                            <dd class="text-gray-800">
                                {{ rtrim(rtrim(number_format($item->weight, 2, '.', ''), '0'), '.') }} lbs
                            </dd>
                        </div>
                    @endif
                    <div>
                        <dt class="font-medium text-gray-600">Magic Item</dt>
                        <dd class="text-gray-800">{{ $item->is_magic_item ? 'Yes' : 'No' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-600">Requires Attunement</dt>
                        <dd class="text-gray-800">
                            {{ $item->requires_attunement ? 'Yes' : 'No' }}
                            @if($item->attunement_requirements)
                                ({{ $item->attunement_requirements }})
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- WEAPON DETAILS --}}
            @if($item->weapon || $item->baseItem?->weapon)
                @php $weapon = $item->weapon ?? $item->baseItem->weapon; @endphp
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Weapon Stats</h2>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        @if($weapon->damage_dice)
                            <div>
                                <dt class="font-medium text-gray-600">Damage</dt>
                                <dd class="text-gray-800">{{ $weapon->damage_dice }} {{ $weapon->damageType?->name }}</dd>
                            </div>
                        @endif
                        @if(!empty($weapon->weapon_category))
                            <div>
                                <dt class="font-medium text-gray-600">Category</dt>
                                <dd class="text-gray-800">{{ $weapon->weapon_category }}</dd>
                            </div>
                        @endif
                        @if(($weapon->range > 0) || ($weapon->long_range > 0))
                            <div>
                                <dt class="font-medium text-gray-600">Range</dt>
                                <dd class="text-gray-800">
                                    {{ intval($weapon->range) }} ft
                                    @if($weapon->long_range > 0)
                                        / {{ intval($weapon->long_range) }} ft
                                    @endif
                                </dd>
                            </div>
                        @endif
                        @if(!empty($weapon->properties))
                            <div>
                                <dt class="font-medium text-gray-600">Properties</dt>
                                <dd class="text-gray-800">{{ $weapon->properties }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif

            {{-- ARMOR DETAILS --}}
            @if($item->armor || $item->baseItem?->armor)
                @php $armor = $item->armor ?? $item->baseItem->armor; @endphp
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Armor Stats</h2>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div>
                            <dt class="font-medium text-gray-600">Base AC</dt>
                            <dd class="text-gray-800">{{ $armor->base_ac }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-600">Dex Modifier</dt>
                            <dd class="text-gray-800">
                                @if($armor->adds_dex_mod)
                                    Yes (cap {{ $armor->dex_mod_cap ?? '∞' }})
                                @else
                                    No
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-600">Stealth Disadvantage</dt>
                            <dd class="text-gray-800">{{ $armor->imposes_stealth_disadvantage ? 'Yes' : 'No' }}</dd>
                        </div>
                        @if($armor->strength_requirement)
                            <div>
                                <dt class="font-medium text-gray-600">Strength Requirement</dt>
                                <dd class="text-gray-800">{{ $armor->strength_requirement }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
