<x-guest-layout>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-teal-950">
            Reset password
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Enter your email and choose a new password
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full focus:border-teal-900 focus:ring-teal-900" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full focus:border-teal-900 focus:ring-teal-900" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full focus:border-teal-900 focus:ring-teal-900"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button
                type="submit"
                class="px-5 py-2.5 bg-teal-950 text-white rounded-lg
                    hover:bg-teal-900 transition cursor-pointer"
            >
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
