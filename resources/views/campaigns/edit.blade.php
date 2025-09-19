@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Campaign</h1>

    <form action="{{ route('campaigns.update', $campaign) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Campaign Name</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name', $campaign->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $campaign->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
