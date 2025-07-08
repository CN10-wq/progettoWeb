@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4 bg-white/5 backdrop-blur-md border-b border-white/10 rounded-t-2xl">
        <div class="text-lg font-bold text-white tracking-wide uppercase font-tit">
            {{ $title }}
        </div>

        <div class="mt-4 text-sm text-white/70 font-testo leading-relaxed">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-white/5 backdrop-blur-md border-t border-white/10 rounded-b-2xl">
        {{ $footer }}
    </div>
</x-modal>
