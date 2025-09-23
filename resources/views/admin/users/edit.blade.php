<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl font-display neon-text">
                Edit User: {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4">
        <div class="max-w-2xl mx-auto">
            <div class="tech-card p-8">

                <!-- Validation Errors -->
                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6 admin-form">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                        <input id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $user->name) }}"
                            required
                            autofocus
                            class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300"
                            placeholder="Enter full name">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                        <input id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300"
                            placeholder="Enter email address">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            New Password <span class="text-gray-500">(leave blank to keep current)</span>
                        </label>
                        <input id="password"
                            name="password"
                            type="password"
                            class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300"
                            placeholder="Enter new password">
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm New Password</label>
                        <input id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300"
                            placeholder="Confirm new password">
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end space-x-4 pt-6">
                        <a href="{{ route('admin.users.index') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 shadow-glow hover:shadow-glow-lg">
                            Update User
                        </button>
                    </div>
                </form>
            </div>

            <!-- User Info Card -->
            <div class="mt-6 tech-card p-6">
                <h3 class="text-lg font-semibold text-white mb-3 font-display">User Information</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-400">User ID:</span>
                        <span class="text-white ml-2 font-mono">{{ $user->id }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400">Joined:</span>
                        <span class="text-white ml-2">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400">Email Verified:</span>
                        @if($user->email_verified_at)
                        <span class="text-green-400 ml-2">✓ Verified</span>
                        @else
                        <span class="text-red-400 ml-2">✗ Unverified</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-gray-400">Total Orders:</span>
                        <span class="text-white ml-2">{{ $user->orders()->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
