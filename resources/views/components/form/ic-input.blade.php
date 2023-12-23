<div @class($class) id="{!! $groupId !!}">
    @if ($label)
        <label for="{!! $id !!}"
            class="mb-6 font-nornal text-sm text-skin-primary">{!! $label !!}</label>
    @endif
    <div class="relative mb-1">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-skin-secondary" xmlns="http://www.w3.org/2000/svg"
                viewBox="{{ $svg->attributes->get('viewBox', '0 0 24 24') }}">
                {{ $svg }}
            </svg>
        </div>
        <input id="{!! $id !!}"
            class="bg-skin-neutral bg-opacity-5 border border-skin-neutral border-opacity-30 text-sm rounded-lg focus:outline-none focus:border-skin-accent focus:shadow-input focus:shadow-skin-accent block w-full pl-10 p-2.5"
            placeholder="{{ $placeholder ?? $label }}" {{ $attributes }} />
    </div>
    @php
        $name = $attributes->get('name', '');
        if (!$hint && $hintType === 'error' && $errors->has($name)) {
            $hint = $errors->first($name);
        }
    @endphp
    @if ($hint)
        <label for="{!! $id !!}" @class([
            'text-xs font-normal leading-normal mt-0',
            'text-skin-danger' => $hintType == 'error',
            'text-skin-warning' => $hintType == 'warning',
            'text-skin-success' => $hintType == 'success',
            'text-skin-secondary' => $hintType == 'none',
        ])>
            {{ $hint }}
        </label>
    @endif
</div>
