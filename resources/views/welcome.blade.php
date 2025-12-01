@extends('layouts.app')

@section('hero')
    <div class="w-full min-h-[350px] max-h-[700px] h-[70vh] overflow-hidden bg-center bg-cover relative flex items-center justify-center text-center"
         style="background-image: url('{{ asset('images/homepage-hero.jpg') }}');">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative z-10 w-full px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="max-w-2xl mx-auto">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white leading-tight">
                    Campaign Compendium
                </h1>

                @guest
                    <p class="mt-4 text-base sm:text-lg text-gray-200">
                        Your all‑in‑one personalized TTRPG campaign manager. Explore SRD items freely, or sign in to manage your own campaigns, characters, and custom items.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row sm:justify-center gap-4">
                        <a href="{{ route('srdItems.index') }}" class="px-6 py-3 bg-purple-800 text-white rounded-lg shadow hover:bg-purple-900 text-center font-semibold">
                            Explore SRD Items
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-white text-gray-800 rounded-lg shadow hover:bg-gray-100 text-center font-semibold">
                            Sign In
                        </a>
                    </div>
                @endguest

                @auth
                    <p class="mt-4 text-base sm:text-lg text-gray-200">
                        Welcome back, {{ Auth::user()->name }}! Jump right into your campaigns, characters, or items.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row sm:justify-center gap-4">
                        <a href="{{ route('campaigns.index') }}" class="px-6 py-3 bg-purple-800 text-white rounded-lg shadow hover:bg-purple-900 text-center">
                            My Campaigns
                        </a>
                        <a href="{{ route('compendium.npcs.index') }}" class="px-6 py-3 bg-white text-gray-800 rounded-lg shadow hover:bg-gray-100 text-center">
                            My Characters
                        </a>
                        <a href="{{ route('items.index') }}" class="px-6 py-3 bg-white text-gray-800 rounded-lg shadow hover:bg-gray-100 text-center">
                            My Items
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Any additional homepage content goes here -->
@endsection
