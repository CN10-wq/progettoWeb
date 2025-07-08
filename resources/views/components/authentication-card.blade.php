<div class="min-h-screen flex items-center justify-center bg-sfondo px-4 sm:px-10 py-10">
    <div class="flex flex-col md:flex-row items-center justify-between gap-8 w-full max-w-full mt-[-40px]">
        
        <div class="w-full md:w-1/5 flex justify-center items-center">
            {{ $logo }}
        </div>

        <div class="w-full md:w-4/5 px-6 sm:px-8 py-6 bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl shadow-xl">
            {{ $slot }}
        </div>

    </div>
</div>

