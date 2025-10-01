<x-admin-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="mx-auto w-16 h-16 bg-gradient-to-r from-red-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-glow mb-6">
                    <span class="text-white font-bold text-2xl font-display">A</span>
                </div>
                <h2 class="text-3xl font-bold font-display neon-text">Admin Login</h2>
                <p class="mt-2 text-sm text-gray-400">
                    Sign in to your admin account
                </p>
            </div>

            <div class="tech-card p-8">
                @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            Email Address
                        </label>
                        <input type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full px-3 py-2 bg-white/10 border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-white placeholder-gray-400">
                        @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            Password
                        </label>
                        <input type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full px-3 py-2 bg-white/10 border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-white placeholder-gray-400">
                        @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox"
                            id="remember"
                            name="remember"
                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-600 rounded bg-white/10">
                        <label for="remember" class="ml-2 block text-sm text-gray-300">
                            Remember me
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300 shadow-glow hover:shadow-glow-lg">
                            Sign In
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-400">
                            Don't have an admin account?
                            <a href="{{ route('admin.register') }}" class="font-medium text-primary-400 hover:text-primary-300 transition-colors">
                                Register here
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>