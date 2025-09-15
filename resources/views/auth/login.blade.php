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
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-primary-100 p-8">
                <x-validation-errors class="mb-4" />

                @session('status')
                <div class="mb-4 p-4 bg-success-50 border border-success-200 rounded-lg">
                    <p class="text-sm text-success-700">{{ $value }}</p>
                </div>
                @endsession

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-secondary-700 mb-2">
                            Email Address
                        </label>
                        <input id="email"
                            class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 bg-white/50 backdrop-blur-sm"
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
                        <label for="password" class="block text-sm font-medium text-secondary-700 mb-2">
                            Password
                        </label>
                        <input id="password"
                            class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 bg-white/50 backdrop-blur-sm"
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
                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-secondary-700">
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
                            class="text-primary-600 hover:text-primary-500 font-medium transition duration-200">
                            Forgot your password?
                        </a>
                        @endif

                        <a href="{{ route('register') }}"
                            class="text-primary-600 hover:text-primary-500 font-medium transition duration-200">
                            Create account
                        </a>
                    </div>
                </form>

                <!-- Or continue with -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-secondary-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-secondary-500">Continue shopping as guest</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('home') }}"
                            class="w-full flex justify-center py-3 px-4 border border-secondary-300 rounded-lg shadow-sm text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200">
                            Browse Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>