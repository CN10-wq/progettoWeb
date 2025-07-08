@props(['for'])

@error($for)
    <p {{ $attributes->merge([
        'class' => 'text-sm text-red-400 mt-2 font-testo tracking-wide'
    ]) }}>{{ $message }}</p>
@enderror

