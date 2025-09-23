<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl font-display neon-text text-red-600">
                Delete Account
            </h2>
            <a href="{{ route('user.profile') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                Back to Profile
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-red-200 dark:border-red-700 border-2">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            <svg class="w-8 h-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <h3 class="text-xl font-medium text-red-600">Permanently Delete Account</h3>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                            <p class="text-red-800 dark:text-red-200 font-medium mb-2">⚠️ Warning: This action cannot be undone!</p>
                            <p class="text-red-700 dark:text-red-300 text-sm">
                                Deleting your account will permanently remove:
                            </p>
                            <ul class="mt-2 text-red-700 dark:text-red-300 text-sm list-disc list-inside space-y-1">
                                <li>Your profile information and settings</li>
                                <li>Your order history and purchase records</li>
                                <li>Your shopping cart and saved items</li>
                                <li>Any uploaded profile photos</li>
                                <li>All associated account data</li>
                            </ul>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('user.destroy') }}" class="space-y-6" id="delete-account-form">
                        @csrf
                        @method('DELETE')

                        <!-- Password Confirmation -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirm Your Password
                            </label>
                            <input type="password"
                                id="password"
                                name="password"
                                required
                                placeholder="Enter your current password"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white">
                            @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmation Text -->
                        <div>
                            <label for="confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type "DELETE" to confirm
                            </label>
                            <input type="text"
                                id="confirmation"
                                name="confirmation"
                                required
                                placeholder="Type DELETE here"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white">
                            @error('confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Terms Acknowledgment -->
                        <div class="flex items-start">
                            <input type="checkbox"
                                id="acknowledge"
                                required
                                class="mt-1 h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <label for="acknowledge" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                I understand that this action is permanent and cannot be undone. I acknowledge that all my data will be permanently deleted.
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('user.profile') }}"
                                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                id="delete-button"
                                disabled
                                class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                                Delete My Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmationInput = document.getElementById('confirmation');
            const acknowledgeCheckbox = document.getElementById('acknowledge');
            const deleteButton = document.getElementById('delete-button');
            const form = document.getElementById('delete-account-form');

            function checkFormValidity() {
                const isConfirmationValid = confirmationInput.value.trim() === 'DELETE';
                const isAcknowledged = acknowledgeCheckbox.checked;
                deleteButton.disabled = !(isConfirmationValid && isAcknowledged);
            }

            confirmationInput.addEventListener('input', checkFormValidity);
            acknowledgeCheckbox.addEventListener('change', checkFormValidity);

            form.addEventListener('submit', function(e) {
                if (!confirm('Are you absolutely sure you want to delete your account? This action cannot be undone.')) {
                    e.preventDefault();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
