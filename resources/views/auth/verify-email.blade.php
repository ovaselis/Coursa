<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-teal-950">
            Verify email
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Check your email and click the verification link to continue.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button
                    type="submit"
                    class="px-5 py-2.5 bg-teal-950 text-white rounded-lg
                        hover:bg-teal-900 transition cursor-pointer"
                >
                    {{ __('Resend Verification Email') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button  type="submit" class="text-sm text-gray-500 hover:text-teal-950 transition cursor-pointer"
            >
                {{ __('Log Out') }}
            </button>
        </form>
    </div> 
</x-guest-layout>
