<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 rounded-2xl flex items-center justify-center mb-6">
                    <span class="text-white font-bold text-2xl">TB</span>
                </div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                    Join TechBuy Today
                </h2>
                <p class="mt-2 text-sm text-secondary-600">
                    Create your account and start shopping for the latest tech
                </p>
            </div>

            <!-- Registration Form -->
            <div class="space-y-6">
                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-white mb-2 font-display">
                            Full Name
                        </label>
                        <input id="name"
                            class="w-full px-4 py-3 bg-white/10 border border-primary-600/30 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-400 transition duration-200 backdrop-blur-sm text-white placeholder-gray-400 font-mono"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Enter your full name">
                    </div>

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
                            autocomplete="new-password"
                            placeholder="Create a password">
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-white mb-2 font-display">
                            Confirm Password
                        </label>
                        <input id="password_confirmation"
                            class="w-full px-4 py-3 bg-white/10 border border-primary-600/30 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-400 transition duration-200 backdrop-blur-sm text-white placeholder-gray-400 font-mono"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Confirm your password">
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <!-- Terms and Privacy -->
                    <div class="flex items-start">
                        <input id="terms"
                            name="terms"
                            type="checkbox"
                            required
                            class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-primary-600/30 rounded mt-1 bg-white/10">
                        <label for="terms" class="ml-2 block text-sm text-white font-display">
                            I agree to the
                            <a target="_blank" href="{{ route('terms.show') }}" class="text-primary-400 hover:text-primary-300 font-medium transition duration-200">Terms of Service</a>
                            and
                            <a target="_blank" href="{{ route('policy.show') }}" class="text-primary-400 hover:text-primary-300 font-medium transition duration-200">Privacy Policy</a>
                        </label>
                    </div>
                    @endif

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-600 to-accent-600 hover:from-primary-700 hover:to-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200 transform hover:scale-[1.02] font-display">
                            Create TechBuy Account
                        </button>
                    </div>

                    <!-- Links -->
                    <div class="text-center">
                        <p class="text-sm text-white font-display">
                            Already have an account?
                            <a href="{{ route('login') }}"
                                class="text-primary-400 hover:text-primary-300 font-medium transition duration-200">
                                Sign in here
                            </a>
                        </p>
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