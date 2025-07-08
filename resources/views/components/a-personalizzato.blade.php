@props(['href' => '#', 'spanAttributes' => collect()])

<a href="{{ $href }}"
   {{ $attributes->merge([
       'class' => 'rounded-full border border-white tracking-wide uppercase backdrop-blur-md bg-white/10 
                   hover:bg-white/90 hover:text-[#2b2b2b] transition-all shadow-sm hover:shadow-lg font-bold inline-flex items-center'
   ]) }}>
    
    {{ $slot }}

    @isset($span)
        <span {{ $spanAttributes->merge(['class' => '']) }}>
            {{ $span }}
        </span>
    @endisset
</a>
