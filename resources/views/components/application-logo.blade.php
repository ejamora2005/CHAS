@php
    $logoCandidates = [
        'image/chas_logo.png',
        'images/chas_logo.png',
        'image/chas_logo.svg',
        'images/chas_logo.svg',
        'image/chas_logo.jpg',
        'images/chas_logo.jpg',
        'image/chas_logo.jpeg',
        'images/chas_logo.jpeg',
        'image/chas_logo.webp',
        'images/chas_logo.webp',
    ];

    $logoAsset = null;
    foreach ($logoCandidates as $candidate) {
        if (file_exists(public_path($candidate))) {
            $logoAsset = asset($candidate);
            break;
        }
    }
@endphp

@if ($logoAsset)
    <img src="{{ $logoAsset }}" alt="{{ config('app.name', 'CHAS') }} logo" {{ $attributes }}>
@else
    <span {{ $attributes->merge(['class' => 'inline-flex items-center justify-center text-emerald-700 font-semibold']) }}>
        CHAS
    </span>
@endif
