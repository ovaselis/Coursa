<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-teal-950">
            Confirm password
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Please confirm your password before continuing
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full focus:border-teal-900 focus:ring-teal-900"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <button
                type="submit"
                class="px-5 py-2.5 bg-teal-950 text-white rounded-lg
                    hover:bg-teal-900 transition cursor-pointer"
            >
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>
