<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl font-display neon-text">
                My Profile
            </h2>
            <a href="{{ route('user.edit') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Edit Profile
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Information Card -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex items-start space-x-6">
                                <!-- Profile Photo -->
                                <div class="flex-shrink-0">
                                    <div class="w-24 h-24 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                        @if ($user->profile_photo_path)
                                        <img src="{{ Storage::url($user->profile_photo_path) }}"
                                            alt="{{ $user->name }}"
                                            class="w-full h-full object-cover">
                                        @else
                                        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                        @endif
                                    </div>
                                </div>

                                <!-- Profile Details -->
                                <div class="flex-1">
                                    <h3 class="text-2xl font-semibold mb-4">{{ $user->name }}</h3>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                                            <p class="text-lg">{{ $user->email }}</p>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Since</label>
                                            <p class="text-lg">{{ $user->created_at->format('F j, Y') }}</p>
                                        </div>

                                        @if ($user->email_verified_at)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Verified</label>
                                            <p class="text-lg text-green-600">✓ Verified</p>
                                        </div>
                                        @else
                                        <div>
                                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Status</label>
                                            <p class="text-lg text-yellow-600">⚠ Not Verified</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Sidebar -->
                <div class="space-y-6">
                    <!-- Account Actions -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Account Actions</h3>
                            <div class="space-y-3">
                                <a href="{{ route('user.edit') }}"
                                    class="w-full flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Profile
                                </a>

                                <a href="{{ route('user.change-password') }}"
                                    class="w-full flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    Change Password
                                </a>

                                <a href="{{ route('user.orders') }}"
                                    class="w-full flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Order History
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-red-200 dark:border-red-700">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-red-600 dark:text-red-400">Danger Zone</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                Once you delete your account, all of your data will be permanently deleted.
                            </p>
                            <a href="{{ route('user.delete-account') }}"
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
