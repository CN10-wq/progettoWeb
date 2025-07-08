@if ($errors->any())
    <div id="error-alert"
         class="relative bg-red-500/10 border border-red-500/20 text-red-300 px-6 py-4 rounded-2xl backdrop-blur-md shadow-md transition duration-300">
        
        <div class="flex items-center mb-2">
           
            <span class="font-semibold text-red-400 tracking-wide uppercase">Attenzione! Qualcosa è andato storto!</span>

            <button id="close-error-alert" class="ml-auto text-red-400 hover:text-red-300 transition text-xl leading-none">
                &times;
            </button>
        </div>

        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
