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
            <div class="flex flex-col sm:flex-row items-start sm:items-center mb-6">
                <div class="flex-1">
                    <div class="flex items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $item->name }}</h1>

                            {{-- tags --}}
                            <div class="mt-3 flex flex-wrap gap-2">
                                @if($item->category)
                                    <span class="bg-purple-50 text-purple-700 text-xs font-medium px-2                          py-1 rounded">
                                        {{ $item->category->name }}
                                    </span>
                                @endif
                                @if($item->rarity)
                                    <span class="bg-indigo-50 text-indigo-700 text-xs font-medium px-2                          py-1 rounded">
                                        {{ $item->rarity->name }}
                                    </span>
                                @endif
                                @if($item->weapon)
                                    <span class="bg-blue-50 text-blue-700 text-xs font-medium px-2 py-1                             rounded">Weapon</span>
                                @elseif($item->armor)
                                    <span class="bg-green-50 text-green-700 text-xs font-medium px-2 py-1                           rounded">Armor</span>
                                @endif
                            </div>
                        </div>

                        {{-- Top-right actions (optional for now) --}}
                        <div class="ml-auto flex gap-2">
                            {{-- Future: edit/delete buttons if you want CRUD --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- /HEADER --}}

            {{-- DESCRIPTION --}}
            @if($item->description)
                <div class="mb-6 prose max-w-none">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Description</h2>
                    {!! Str::markdown($item->description) !!}
                </div>
            @endif
            {{-- /DESCRIPTION --}}

            {{-- DETAILS --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Details</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    <div>
                        <dt class="font-medium text-gray-600">Cost</dt>
                        <dd class="text-gray-800">
                            @if($item->cost && $item->cost > 0)
                                {{ rtrim(rtrim(number_format($item->cost, 2, '.', ''), '0'), '.') }} GP
                            @else
                                —
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-600">Weight</dt>
                        <dd class="text-gray-800">
                            @if($item->weight && $item->weight > 0)
                                {{ rtrim(rtrim(number_format($item->weight, 2, '.', ''), '0'), '.') }} lbs
                            @else
                                —
                            @endif
                        </dd>
                    </div>
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
            @if($item->weapon)
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Weapon Stats</h2>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div>
                            <dt class="font-medium text-gray-600">Damage</dt>
                            <dd class="text-gray-800">{{ $item->weapon->damage_dice }} {{ $item->weapon->damageType?->name }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-600">Category</dt>
                            <dd class="text-gray-800">{{ $item->weapon->weapon_category }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-600">Range</dt>
                            <dd class="text-gray-800">
                                {{ $item->weapon->range_normal }}
                                @if($item->weapon->range_long)
                                    / {{ $item->weapon->range_long }}
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-600">Properties</dt>
                            <dd class="text-gray-800">{{ $item->weapon->properties ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            @endif

            {{-- ARMOR DETAILS --}}
            @if($item->armor)
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Armor Stats</h2>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div>
                            <dt class="font-medium text-gray-600">Base AC</dt>
                            <dd class="text-gray-800">{{ $item->armor->base_ac }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-600">Dex Modifier</dt>
                            <dd class="text-gray-800">
                                @if($item->armor->adds_dex_mod)
                                    Yes (cap {{ $item->armor->dex_mod_cap ?? '∞' }})
                                @else
                                    No
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-600">Stealth Disadvantage</dt>
                            <dd class="text-gray-800">{{ $item->armor->imposes_stealth_disadvantage ? 'Yes' : 'No' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-600">Strength Requirement</dt>
                            <dd class="text-gray-800">{{ $item->armor->strength_requirement ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
