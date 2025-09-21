<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-black via-gray-900 to-black relative">
    <!-- Tech Grid Background -->
    <div class="absolute inset-0 opacity-20">
        <div class="tech-grid"></div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute inset-0">
        <div class="floating-element absolute top-20 left-10 w-2 h-2 bg-primary-400 rounded-full"></div>
        <div class="floating-element absolute top-32 right-20 w-3 h-3 bg-accent-400 rounded-full" style="animation-delay: 1s;"></div>
        <div class="floating-element absolute bottom-40 left-1/4 w-1 h-1 bg-secondary-400 rounded-full" style="animation-delay: 2s;"></div>
        <div class="floating-element absolute top-1/2 right-1/3 w-2 h-2 bg-primary-300 rounded-full" style="animation-delay: 3s;"></div>
    </div>

    <div class="relative z-10">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 tech-card shadow-glow relative z-10">
        {{ $slot }}
    </div>
</div>