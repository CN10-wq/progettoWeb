@props(['inputId'])

<button type="button"
        onclick="togglePasswordVisibility('{{ $inputId }}', event)"
        class="absolute right-3 top-1/2 -translate-y-1/2 z-10 text-white/70 hover:text-white">

    <svg class="h-5 w-5 eye-open" xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
              -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
    </svg>

    <svg class="h-5 w-5 eye-closed hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7
              a10.05 10.05 0 012.166-3.294M6.106 6.106A10.012 10.012 0 0112 5
              c4.477 0 8.268 2.943 9.542 7a9.967 9.967 0 01-4.075 5.053M15 12a3 3 0 11-6 0
              3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
    </svg>
</button>
