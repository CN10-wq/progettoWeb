<div class="md:col-span-1 flex flex-col justify-between">
    <div class="px-4 sm:px-0">
        <h3 class="text-xl font-bold text-white uppercase tracking-wide font-tit">
            {{ $title }}
        </h3>

        <p class="mt-2 text-sm text-white/70 leading-relaxed font-testo">
            {{ $description }}
        </p>
    </div>

    @isset($aside)
        <div class="px-4 sm:px-0 mt-4 sm:mt-0 text-white/60">
            {{ $aside }}
        </div>
    @endisset
</div>

