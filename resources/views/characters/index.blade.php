<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Character Compendium') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 prose dark:prose-invert">
                    <p>This is where your characters and NPCs will appear.</p>

                    <!-- Placeholder table -->
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full border border-gray-300 dark:border-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left">Name</th>
                                    <th class="px-4 py-2 text-left">Type</th>
                                    <th class="px-4 py-2 text-left">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-t px-4 py-2">Example Character</td>
                                    <td class="border-t px-4 py-2">NPC</td>
                                    <td class="border-t px-4 py-2">A placeholder entry.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
