<x-cards.card {{$attributes->merge(['class' => 'p-8 flex items-center'])}}>
    <div class="p-2 rounded-full {{$svg->attributes->get('icon-class', '')}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
            viewBox="{{ $svg->attributes->get('viewBox', '0 0 24 24') }}">
            {{ $svg }}
        </svg>
    </div>
    <div class="flex-grow ml-4">
        <h4 class="text-skin-primary font-bold text-xl">{{ $value }}</h4>
        <p class="text-skin-secondary text-sm">{{ $slot }}</p>
    </div>
</x-cards.card>
