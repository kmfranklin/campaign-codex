<x-app-layout>
    <div class="prose max-w-none">
        <h1>Example Page</h1>
        <p>
            This page demonstrates the <code>prose</code> typography styles and a responsive card grid.
            Resize your browser to see the layout adapt from mobile to desktop.
        </p>
    </div>

    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach (range(1, 6) as $i)
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold mb-2">Card {{ $i }}</h2>
                <p class="text-sm text-gray-600">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus.
                </p>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        <form action="#" method="POST">
            @csrf
            <x-form.field label="Example Input" name="example" placeholder="Type something..." />
            <button type="submit"
                    class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                Submit
            </button>
        </form>
    </div>
</x-app-layout>
