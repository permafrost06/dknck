<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ $home['link'] }}" class="inline-flex items-center font-medium text-skin-primary hover:text-skin-accent">
                <svg aria-hidden="true" class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 256 256">
                    <path fill="currentColor"
                        d="M208 36H48a28 28 0 0 0-28 28v112a28 28 0 0 0 28 28h160a28 28 0 0 0 28-28V64a28 28 0 0 0-28-28Zm4 140a4 4 0 0 1-4 4H48a4 4 0 0 1-4-4V64a4 4 0 0 1 4-4h160a4 4 0 0 1 4 4Zm-40 52a12 12 0 0 1-12 12H96a12 12 0 0 1 0-24h64a12 12 0 0 1 12 12Z" />
                </svg>
                {{ $home['label'] }}
            </a>
        </li>
        @foreach ($items as $item)
            <li>
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-skin-secondary" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    @if (isset($item['link']))
                        <a href="{{ $item['link'] }}"
                            class="ml-1 font-medium text-skin-primary hover:text-skin-accent md:ml-2">{{ $item['label'] }}</a>
                    @else
                        {{ $item['label'] }}
                    @endif

                </div>
            </li>
        @endforeach
        @if($active)
        <li aria-current="page">
            <div class="flex items-center">
                <svg aria-hidden="true" class="w-6 h-6 text-skin-secondary" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="ml-1 font-medium text-skin-secondary md:ml-2">{{ $active }}</span>
            </div>
        </li>
        @endif
    </ol>
</nav>
