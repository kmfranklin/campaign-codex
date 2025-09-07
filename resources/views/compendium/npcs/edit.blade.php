@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6">Edit NPC</h1>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('compendium.npcs.update', $npc) }}" method="POST" class="space-y-10">
        @csrf
        @method('PUT')

        {{-- Core Identity --}}
        <section>
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Core Identity</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form.field label="Name" name="name" :value="$npc->name" required />
                <x-form.field label="Alias" name="alias" :value="$npc->alias" />
                <x-form.field label="Race" name="race" :value="$npc->race" />
                <x-form.field label="Class" name="class" :value="$npc->class" />
                <x-form.field label="Role" name="role" :value="$npc->role" />
                <x-form.field label="Alignment" name="alignment" :value="$npc->alignment" />
                <x-form.field label="Location" name="location" :value="$npc->location" />
                <x-form.field label="Status" name="status" :value="$npc->status" />
                <x-form.field label="Portrait Path" name="portrait_path" :value="$npc->portrait_path" />
            </div>
        </section>

        {{-- Descriptive --}}
        <section>
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Descriptive</h2>
            <div class="space-y-4">
                <x-form.field label="Description" name="description" type="textarea" rows="3" :value="$npc->description" />
                <x-form.field label="Personality" name="personality" type="textarea" rows="3" :value="$npc->personality" />
                <x-form.field label="Quirks" name="quirks" type="textarea" rows="3" :value="$npc->quirks" />
            </div>
        </section>

        {{-- Combat Stats --}}
        <section>
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Abilities +  Stats</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach (['strength','dexterity','constitution','intelligence','wisdom','charisma'] as $stat)
                    <x-form.field label="{{ ucfirst($stat) }}" name="{{ $stat }}" type="number" min="1" max="30" :value="$npc->$stat" />
                @endforeach
                <x-form.field label="Armor Class" name="armor_class" type="number" min="0" max="50" :value="$npc->armor_class" />
                <x-form.field label="Hit Points" name="hit_points" type="number" min="0" :value="$npc->hit_points" />
                <x-form.field label="Speed" name="speed" :value="$npc->speed" />
                <x-form.field label="Challenge Rating" name="challenge_rating" :value="$npc->challenge_rating" />
                <x-form.field label="Proficiency Bonus" name="proficiency_bonus" type="number" min="0" max="10" :value="$npc->proficiency_bonus" />
            </div>
        </section>

        {{-- Submit --}}
        <div class="pt-4 border-t flex justify-between">
            <a href="{{ route('compendium.npcs.show', $npc) }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Update NPC
            </button>
        </div>
    </form>
</div>
@endsection
