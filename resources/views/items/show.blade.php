@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
  {{-- Back link --}}
  @php
  use Illuminate\Support\Facades\Route;

  // Map logical keys to your actual route names
  $expected = [
    'all'    => 'items.index',
    'custom' => 'customItems.index',
    'srd'    => 'srdItems.index',
  ];

  // Helper that resolves a named route only when it exists
  $getRouteUrl = function(?string $routeName, $fallback = null) {
      if ($routeName && Route::has($routeName)) {
          return route($routeName);
      }
      return $fallback;
  };

  // 1) explicit ?from= param wins when valid
  $fromKey = request()->query('from');
  if ($fromKey && isset($expected[$fromKey]) && Route::has($expected[$fromKey])) {
      $backUrl = route($expected[$fromKey]);
  } else {
      // 2) prefer the literal previous URL if it points to a known index path
      $previous = url()->previous();
      $prevPath = parse_url($previous, PHP_URL_PATH) ?: null;

      // Build the allowed index paths (path-only) from the named routes that exist
      $allowedPaths = [];
      foreach ($expected as $key => $routeName) {
          if (Route::has($routeName)) {
              $allowedPaths[] = parse_url(route($routeName), PHP_URL_PATH);
          }
      }

      if ($prevPath && in_array($prevPath, $allowedPaths, true)) {
          $backUrl = $previous;
      } else {
          // 3) prefer stored full index URL (session) if present
          $lastUrl = session('items.last_index_url');
          if ($lastUrl) {
              $backUrl = $lastUrl;
          } else {
              // 4) fall back to session key mapping -> named route if defined, otherwise items.index
              $lastKey = session('items.last_index');
              $backUrl = $getRouteUrl($expected[$lastKey] ?? null, route('items.index'));
          }
      }
  }
  @endphp

  <a href="{{ $backUrl }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900 mb-4   font-medium">
    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"   stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
    </svg>
    Back to Items
  </a>

  <div class="bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden">
    {{-- HEADER --}}
    <div class="flex items-start p-6 border-b border-gray-200">
      <div class="flex-1">
        <div class="flex items-start">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $item->name }}</h1>

            {{-- Tags + inline property chips --}}
            @php
              $itemTags = [];
              if (optional($item->category)->name) $itemTags[] = ['label' => optional($item->category)->name, 'bg' => 'bg-gray-50', 'text' => 'text-gray-700'];
              if (optional($item->rarity)->name) $itemTags[] = ['label' => optional($item->rarity)->name, 'bg' => 'bg-yellow-50', 'text' => 'text-yellow-700'];
              if (! $item->is_srd) $itemTags[] = ['label' => 'Custom', 'bg' => 'bg-green-50', 'text' => 'text-green-700'];

              $inlineProps = [];
              if ($item->is_magic_item) $inlineProps[] = ['label' => 'Magic Item', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-700'];
              if ($item->requires_attunement) $inlineProps[] = ['label' => 'Requires Attunement', 'bg' => 'bg-red-50', 'text' => 'text-red-700'];
              if (optional($item->armor)->adds_dex_mod) $inlineProps[] = ['label' => 'Adds Dex Mod', 'bg' => 'bg-gray-100', 'text' => 'text-gray-700'];
            @endphp

            <div class="mt-3 flex flex-wrap gap-2 items-center">
              <span class="bg-indigo-50 text-indigo-700 text-xs font-medium px-2 py-1 rounded">Item</span>

              @foreach($itemTags as $tag)
                <span class="{{ $tag['bg'] }} {{ $tag['text'] }} text-xs font-medium px-2 py-1 rounded">{{ $tag['label'] }}</span>
              @endforeach

              @foreach($inlineProps as $p)
                <span class="{{ $p['bg'] }} {{ $p['text'] }} text-xs px-2 py-0.5 rounded">{{ $p['label'] }}</span>
              @endforeach
            </div>
          </div>

          {{-- Actions --}}
          <div class="ml-auto flex gap-2">
            @can('update', $item)
              <a href="{{ route('items.edit', $item) }}?from=custom"
                 class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded">Edit</a>
            @endcan

            @can('delete', $item)
              <form action="{{ route('items.destroy', $item) }}" method="POST"
                    onsubmit="return confirm('Delete this item? This action cannot be undone.');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">Delete</button>
              </form>
            @endcan

            <a href="{{ route('items.custom.create', ['base_item_id' => $item->id, 'from' => 'custom']) }}"
               class="px-4 py-2 bg-purple-700 hover:bg-purple-800 text-white rounded">Clone</a>
          </div>
        </div>
      </div>
    </div>

    {{-- Prepare displayWeapon if not passed from controller (safe) --}}
    @php
      if (!isset($displayWeapon)) {
        $weaponSource = $item->weapon ?? optional($item->baseItem)->weapon ?? null;
        $magicBonus = $item->magic_bonus ?? null;
        if (is_null($magicBonus) && preg_match('/\+(\d+)/', $item->name, $m)) {
          $magicBonus = intval($m[1]);
        }
        $baseDamageDice = optional($weaponSource)->damage_dice;
        $damageTypeName = optional(optional($weaponSource)->damageType)->name;
        $damageString = null;
        if ($baseDamageDice) {
          $damageString = trim($baseDamageDice . ($magicBonus ? " +{$magicBonus}" : '') . ($damageTypeName ? " {$damageTypeName}" : ''));
        }
        $displayWeapon = $weaponSource ? [
          'base_damage_dice' => $baseDamageDice,
          'damage_type' => $damageTypeName,
          'damageString' => $damageString,
          'attackBonus' => $magicBonus ? "+{$magicBonus}" : null,
          'range' => optional($weaponSource)->range,
          'long_range' => optional($weaponSource)->long_range,
          'distance_unit' => optional($weaponSource)->distance_unit ?? 'ft',
          'is_improvised' => optional($weaponSource)->is_improvised,
          'is_simple' => optional($weaponSource)->is_simple,
          'source' => $item->weapon ? 'item' : (optional($item->baseItem)->weapon ? 'base' : null),
        ] : null;
      }
    @endphp

    {{-- Quick facts: Base AC and Dex Cap shown here; do NOT include Adds Dex Mod in quick tiles --}}
    @php
      $hasMeaningfulNumber = function($v) {
        if (is_null($v) || $v === '') return false;
        if (is_numeric($v)) return floatval($v) !== 0.0;
        return trim((string)$v) !== '0' && trim((string)$v) !== '0.00';
      };

      $quick = ['Cost' => $item->cost, 'Weight' => $item->weight];

      // Only add Magic/Attunement tiles when true
      if ($item->is_magic_item) $quick['Magic Item'] = 'Yes';
      if ($item->requires_attunement) $quick['Requires Attunement'] = 'Yes';

      // armor summary: put Base AC and Dex Cap into quick tiles, but NOT Adds Dex Mod
      if (optional($item->armor)->exists()) {
        $armor = $item->armor;
        $quick['Base AC'] = $armor->base_ac ?? null;
        if (!is_null($armor->dex_mod_cap)) {
          $quick['Dex Cap'] = $armor->dex_mod_cap;
        }
        if (!is_null($armor->strength_requirement) && $armor->strength_requirement !== '') {
          $quick['Strength Req'] = $armor->strength_requirement;
        }
      }

      // Do not add Damage to quick tiles; weapon details handle that.
      $displayQuick = array_filter($quick, function($v, $k) use ($hasMeaningfulNumber) {
        if (in_array($k, ['Magic Item','Requires Attunement','Base AC'])) {
          return !is_null($v) && $v !== '';
        }
        if (in_array($k, ['Cost','Weight','Dex Cap','Strength Req'])) {
          return $hasMeaningfulNumber($v);
        }
        return !is_null($v) && $v !== '';
      }, ARRAY_FILTER_USE_BOTH);
    @endphp

    @if(count($displayQuick))
      <div class="p-4 border-b border-gray-100 bg-white">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          @foreach($displayQuick as $label => $value)
            <div class="bg-white border border-gray-200 rounded-lg p-3 text-center">
              <div class="text-xs font-medium text-gray-600 uppercase">{{ $label }}</div>
              <div class="mt-1 text-sm font-semibold text-gray-900">{{ $value }}</div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    {{-- Main content grid --}}
    <div class="md:flex md:items-start">
      {{-- Left column --}}
      <div class="md:flex-1">
        {{-- Description --}}
        @if($item->description)
          <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Description</h2>
            <p class="text-gray-800 whitespace-pre-line">{{ $item->description }}</p>
          </div>
        @endif

        {{-- Weapon details (components only) --}}
        @if(!empty($displayWeapon))
          <div class="p-6 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Weapon Details</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
              @if(!empty($displayWeapon['base_damage_dice']))
                <div>
                  <dt class="font-medium text-gray-600">Damage Dice</dt>
                  <dd class="text-gray-800">
                    {{ $displayWeapon['base_damage_dice'] }}
                    @if(!empty($displayWeapon['damage_type'])) {{ $displayWeapon['damage_type'] }}@endif
                    @if(!empty($displayWeapon['source']) && $displayWeapon['source'] === 'base')
                      <span class="text-xs text-gray-500 ml-2">(from base)</span>
                    @endif
                  </dd>
                </div>
              @endif

              @if(!empty($displayWeapon['attackBonus']))
                <div>
                  <dt class="font-medium text-gray-600">Damage Modifier</dt>
                  <dd class="text-gray-800">{{ $displayWeapon['attackBonus'] }}</dd>
                </div>
              @endif

              @php
                $hasRange = (isset($displayWeapon['range']) && $displayWeapon['range'] !== '' && floatval($displayWeapon['range']) !== 0)
                         || (isset($displayWeapon['long_range']) && $displayWeapon['long_range'] !== '' && floatval($displayWeapon['long_range']) !== 0);
              @endphp
              @if($hasRange)
                <div>
                  <dt class="font-medium text-gray-600">Range</dt>
                  <dd class="text-gray-800">
                    {{ $displayWeapon['range'] ?? '—' }}
                    @if(!empty($displayWeapon['long_range']) && floatval($displayWeapon['long_range']) !== 0)
                      / {{ $displayWeapon['long_range'] }} {{ $displayWeapon['distance_unit'] ?? 'ft' }}
                    @endif
                  </dd>
                </div>
              @endif
            </div>
          </div>
        @endif

        {{-- Armor details: render only when quick tiles did NOT show both Base AC and Dex Cap --}}
        @php
          $armorQuickHasBase = isset($displayQuick['Base AC']) && $displayQuick['Base AC'] !== '';
          $armorQuickHasDexCap = isset($displayQuick['Dex Cap']) && $displayQuick['Dex Cap'] !== '';
        @endphp

        @if(optional($item->armor)->exists() && !($armorQuickHasBase && $armorQuickHasDexCap))
          @php
            $armor = $item->armor;
            // Do NOT include Adds Dex Mod here (it is shown only as inline chip)
            $armorProps = [];
            if ($armor->imposes_stealth_disadvantage) $armorProps[] = 'Stealth Disadvantage';
          @endphp

          <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Armor Details</h2>

            <div class="grid grid-cols-2 gap-4 text-sm">
              @if(!is_null($armor->base_ac) && !empty($armor->base_ac))
                <div>
                  <dt class="font-medium text-gray-600">Base AC</dt>
                  <dd class="text-gray-800">{{ $armor->base_ac }}</dd>
                </div>
              @endif

              @if($armor->adds_dex_mod)
                <div>
                  <dt class="font-medium text-gray-600">Dex Cap</dt>
                  <dd class="text-gray-800">{{ is_null($armor->dex_mod_cap) ? 'Uncapped' : $armor->dex_mod_cap }}</dd>
                </div>
              @elseif(!is_null($armor->dex_mod_cap))
                <div>
                  <dt class="font-medium text-gray-600">Dex Cap</dt>
                  <dd class="text-gray-800">{{ $armor->dex_mod_cap }}</dd>
                </div>
              @endif

              @if(!is_null($armor->strength_requirement) && $armor->strength_requirement !== '')
                <div>
                  <dt class="font-medium text-gray-600">Strength Requirement</dt>
                  <dd class="text-gray-800">{{ $armor->strength_requirement }}</dd>
                </div>
              @endif

              @if(count($armorProps))
                <div>
                  <dt class="font-medium text-gray-600">{{ count($armorProps) > 1 ? 'Properties' : '' }}</dt>
                  <dd>
                    @foreach($armorProps as $p)
                      <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded mr-2">{{ $p }}</span>
                    @endforeach
                  </dd>
                </div>
              @endif
            </div>
          </div>
        @endif
      </div>

      {{-- Right column: Details aside (render only if it has content) --}}
      @php
        $hasDetails = false;
        if ($item->base_item_id) $hasDetails = true;
        if (! $item->is_srd && $item->created_at) $hasDetails = true;
        if ($item->user_id) $hasDetails = true;
      @endphp

      @if($hasDetails)
        <aside class="md:w-80 border-l border-gray-100 bg-white">
          <div class="p-6">
            <h3 class="text-sm font-semibold text-gray-600 mb-3 border-b pb-2">Details</h3>
            <dl class="text-sm text-gray-800 space-y-2">
              @if($item->base_item_id)
                <div>
                  <dt class="font-medium text-gray-600">Base Item</dt>
                  <dd>
                    <a href="{{ route('items.show', $item->baseItem) }}" class="text-purple-700 hover:underline">
                      {{ optional($item->baseItem)->name }}
                    </a>
                  </dd>
                </div>
              @endif

              @if(! $item->is_srd && $item->created_at)
                <div>
                  <dt class="font-medium text-gray-600">Created</dt>
                  <dd>{{ $item->created_at?->diffForHumans() }}</dd>
                </div>
              @endif

              @if($item->user_id)
                <div>
                  <dt class="font-medium text-gray-600">Owner</dt>
                  <dd>{{ optional($item->user)->name }}</dd>
                </div>
              @endif
            </dl>
          </div>
        </aside>
      @endif
    </div>
  </div>
</div>
@endsection
