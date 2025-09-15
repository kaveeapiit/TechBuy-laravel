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
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-primary-100 p-8">
                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-secondary-700 mb-2">
                            Full Name
                        </label>
                        <input id="name"
                            class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 bg-white/50 backdrop-blur-sm"
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
                        <label for="email" class="block text-sm font-medium text-secondary-700 mb-2">
                            Email Address
                        </label>
                        <input id="email"
                            class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 bg-white/50 backdrop-blur-sm"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
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
                            autocomplete="new-password"
                            placeholder="Create a password">
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-secondary-700 mb-2">
                            Confirm Password
                        </label>
                        <input id="password_confirmation"
                            class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 bg-white/50 backdrop-blur-sm"
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
                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300 rounded mt-1">
                        <label for="terms" class="ml-2 block text-sm text-secondary-700">
                            I agree to the
                            <a target="_blank" href="{{ route('terms.show') }}" class="text-primary-600 hover:text-primary-500 font-medium">Terms of Service</a>
                            and
                            <a target="_blank" href="{{ route('policy.show') }}" class="text-primary-600 hover:text-primary-500 font-medium">Privacy Policy</a>
                        </label>
                    </div>
                    @endif

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-600 to-accent-600 hover:from-primary-700 hover:to-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200 transform hover:scale-[1.02]">
                            Create TechBuy Account
                        </button>
                    </div>

                    <!-- Links -->
                    <div class="text-center">
                        <p class="text-sm text-secondary-600">
                            Already have an account?
                            <a href="{{ route('login') }}"
                                class="text-primary-600 hover:text-primary-500 font-medium transition duration-200">
                                Sign in here
                            </a>
                        </p>
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