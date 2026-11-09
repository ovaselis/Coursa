<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-teal-950">
            Forgot password
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Enter your email and we will send you a password reset link
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full focus:border-teal-900 focus:ring-teal-900" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class=" text-sm ms-3 px-3 py-2 bg-teal-950 text-white rounded-lg
           hover:bg-teal-900 transition cursor-pointer">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
