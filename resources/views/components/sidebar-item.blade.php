<li class="my-2">
    <a href="{{ $link }}" @class([
        'flex items-center p-2 collapsed:md:max-w-min hover:bg-skin-accent hover:bg-opacity-20 rounded-md',
        'bg-skin-accent text-skin-accent bg-opacity-10' => Route::currentRouteName() == $route,
    ])>
        @isset($svg)
            <svg class="mr-2 collapsed:md:mr-0" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                viewBox="{{ $svg->attributes->get('viewBox', '0 0 24 24') }}">
                {{ $svg }}
            </svg>
        @endisset
        <div class="flex-grow font-medium text-sm collapsed:md:hidden">
            {{ $slot }}
        </div>
    </a>
</li>
