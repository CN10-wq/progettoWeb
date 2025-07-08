<div {{ $attributes }}>
    {{ $slot }}
</div>

<div id="lightbox" style="display: none;"
     class="fixed inset-0 bg-black/90 flex items-center justify-center z-50 transition-opacity duration-300 opacity-0">
    <button id="lightbox-close"
            class="absolute top-6 right-6 text-white text-3xl font-bold hover:text-white/50">
        &times;
    </button>
    <img id="lightbox-img"
         src=""
         alt="Preview"
         class="max-h-[90vh] max-w-[90vw] object-contain rounded shadow-lg">
</div>

