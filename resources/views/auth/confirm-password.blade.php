<x-authentication-layout>
    <div class="flex justify-center items-center min-h-screen px-4">
        <div class="w-full max-w-md bg-white/5 border border-white/10 backdrop-blur-md rounded-2xl shadow-xl p-8 text-white space-y-6">

            <div class="flex justify-center">
                <x-authentication-card-logo />
            </div>

            <div class="text-sm text-white/80 tracking-wide leading-relaxed text-center">
                {{ __('Questa è un\'area riservata dell\'applicazione. Per favore, conferma la tua password prima di procedere.') }}
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

                <div>
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input
                        id="password"
                        class="mt-1 block w-full bg-white/10 text-white border border-white/20 rounded-lg px-4 py-2"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        autofocus
                    />
                </div>

                <div class="flex justify-end">
                    <x-button class="px-5 py-2 text-sm rounded-xl bg-white/10 hover:bg-white/20 border border-white/30 transition">
                        {{ __('Conferma') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-authentication-layout>
