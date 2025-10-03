@if(session()->has('success'))
    <div class="mb-4 rounded bg-green-100 border border-green-300 text-green-800 px-4 py-2">
        {{ session('success') }}
    </div>
@endif

@if(session()->has('error'))
    <div class="mb-4 rounded bg-red-100 border border-red-300 text-red-800 px-4 py-2">
        {{ session('error') }}
    </div>
@endif

@if(session()->has('warning'))
    <div class="mb-4 rounded bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-2">
        {{ session('warning') }}
    </div>
@endif

@if(session()->has('info'))
    <div class="mb-4 rounded bg-blue-100 border border-blue-300 text-blue-800 px-4 py-2">
        {{ session('info') }}
    </div>
@endif
