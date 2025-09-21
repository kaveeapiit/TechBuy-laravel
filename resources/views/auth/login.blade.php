<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 rounded-2xl flex items-center justify-center mb-6">
                    <span class="text-white font-bold text-2xl">TB</span>
                </div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                    Welcome back to TechBuy
                </h2>
                <p class="mt-2 text-sm text-secondary-600">
                    Sign in to your account to continue shopping
                </p>
            </div>

            <!-- Login Form -->
            <div class="space-y-6">
                <x-validation-errors class="mb-4" />

                @session('status')
                <div class="mb-4 p-4 bg-secondary-500/20 border border-secondary-400/30 rounded-lg backdrop-blur-sm">
                    <p class="text-sm text-secondary-200">{{ $value }}</p>
                </div>
                @endsession

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-2 font-display">
                            Email Address
                        </label>
                        <input id="email"
                            class="w-full px-4 py-3 bg-white/10 border border-primary-600/30 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-400 transition duration-200 backdrop-blur-sm text-white placeholder-gray-400 font-mono"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Enter your email">
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-white mb-2 font-display">
                            Password
                        </label>
                        <input id="password"
                            class="w-full px-4 py-3 bg-white/10 border border-primary-600/30 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-400 transition duration-200 backdrop-blur-sm text-white placeholder-gray-400 font-mono"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password">
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-primary-600/30 rounded bg-white/10">
                        <label for="remember_me" class="ml-2 block text-sm text-white font-display">
                            Remember me
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-600 to-accent-600 hover:from-primary-700 hover:to-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200 transform hover:scale-[1.02]">
                            Sign in to TechBuy
                        </button>
                    </div>

                    <!-- Links -->
                    <div class="flex items-center justify-between text-sm">
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-primary-400 hover:text-primary-300 font-medium transition duration-200 font-display">
                            Forgot your password?
                        </a>
                        @endif

                        <a href="{{ route('register') }}"
                            class="text-primary-400 hover:text-primary-300 font-medium transition duration-200 font-display">
                            Create account
                        </a>
                    </div>
                </form>

                <!-- Or continue with -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-primary-600/30"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-gray-900 text-gray-400 font-mono">Continue shopping as guest</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('home') }}"
                            class="w-full flex justify-center py-3 px-4 border border-primary-600/30 rounded-lg shadow-sm text-sm font-medium text-white bg-white/10 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200 backdrop-blur-sm font-display">
                            Browse Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>