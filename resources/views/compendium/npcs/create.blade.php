{{-- resources/views/npcs/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6">Create NPC</h1>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('compendium.npcs.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-10">
        @csrf

        {{-- Core Identity --}}
        <section>
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Core Identity</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form.field label="Name" name="name" required />
                <x-form.field label="Alias" name="alias" />
                <x-form.select
                    name="race"
                    label="Race/Species"
                    :options="\App\Models\Npc::raceOptions()"
                    placeholder="Choose Race/Species" />
                <x-form.select
                    name="class"
                    label="Class"
                    :options="\App\Models\Npc::classOptions()"
                    placeholder="Choose Class" />
                <x-form.select
                    name="role"
                    label="Role"
                    :options="\App\Models\Npc::socialRoleOptions()"
                    placeholder="Choose Role" />
                <x-form.select
                    name="alignment"
                    label="Alignment"
                    :options="\App\Models\Npc::alignmentOptions()"
                    placeholder="Choose Alignment" />
                <x-form.field label="Location" name="location" />
                <x-form.select
                    label="Status"
                    name="status"
                    :options="\App\Models\Npc::statusOptions()"
                    placeholder="Choose Status" />

                {{-- Portrait upload --}}
                <div>
                    <label for="portrait" class="block text-sm font-medium text-gray-700">Portrait</label>
                    <input id="portrait"
                           name="portrait"
                           type="file"
                           accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-700
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100" />
                </div>
            </div>
        </section>

        {{-- Descriptive --}}
        <section>
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Descriptive</h2>
            <div class="space-y-4">
                <x-form.field label="Description" name="description" type="textarea" rows="3" />
                <x-form.field label="Personality" name="personality" type="textarea" rows="3" />
                <x-form.field label="Quirks" name="quirks" type="textarea" rows="3" />
            </div>
        </section>

        {{-- Abilities + Stats --}}
        <section>
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Abilities + Stats</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach (['strength','dexterity','constitution','intelligence','wisdom','charisma'] as $stat)
                    <x-form.field
                        label="{{ ucfirst($stat) }}"
                        name="{{ $stat }}"
                        type="number"
                        min="1"
                        max="30" />
                @endforeach
                <x-form.field label="Armor Class" name="armor_class" type="number" min="0" max="50" />
                <x-form.field label="Hit Points" name="hit_points" type="number" min="0" />
                <x-form.field label="Speed" name="speed" />
                <x-form.field label="Challenge Rating" name="challenge_rating" />
                <x-form.field label="Proficiency Bonus" name="proficiency_bonus" type="number" min="0" max="10" />
            </div>
        </section>

        {{-- Submit --}}
        <div class="pt-4 border-t">
            <button
                type="submit"
                class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Create NPC
            </button>
        </div>
    </form>
</div>
@endsection
