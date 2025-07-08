{{--
    Pagina di creazione di un nuovo admin, in cui si inseriscono nome, cognome, mail e password.
--}}
<x-app-layout :title="'Nuovo Admin'">
    <div class="max-w-full py-12 px-10 sm:px-6 lg:px-20 xl:px-20 text-white space-y-10">
        <br>

        <h1 class="text-3xl font-bold italic text-center">Aggiungi un nuovo amministratore</h1>

        @if (session('success'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition.duration.500ms
                class="bg-white/10 text-white/80 border border-white/30 rounded-xl px-4 py-3 backdrop-blur-md shadow-md text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.store') }}" class="space-y-6">
            @csrf

            <div>
                <x-label for="name" value="Nome" />
                <x-input id="name" type="text" name="name" class="mt-1 block w-full" required />
            </div>

            <div>
                <x-label for="surname" value="Cognome" />
                <x-input id="surname" type="text" name="surname" class="mt-1 block w-full" required />
            </div>

            <div>
                <x-label for="email" value="Email" />
                <x-input id="email" type="email" name="email" class="mt-1 block w-full" required />
            </div>

            <div>
                <x-label for="password" value="Password" />
                <div class="relative">
                    <x-input id="password" type="password" name="password" class="mt-1 block w-full" required />
                    <x-password input-id="password" />
                </div>
            </div>

            <br>

            <div class="flex justify-end">
                <x-button class="px-6 py-2 text-sm whitespace-nowrap">
                    Crea Admin
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>
