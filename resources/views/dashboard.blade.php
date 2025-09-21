<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl font-display neon-text">
                Welcome back, {{ Auth::user()->name }}!
            </h2>
            <div class="text-sm text-gray-400 font-mono">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    @livewire('user-dashboard')
</x-app-layout>