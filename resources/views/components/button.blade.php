<button type="{{ $type }}" {{ $attributes }} @class([
    'focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none',
    'text-skin-inverted bg-skin-accent hover:bg-skin-accent-hover focus:ring-skin-accent' =>
        $variant === 'primary',
    'text-skin-inverted bg-skin-success bg-opacity-90 hover:bg-opacity-100 focus:ring-skin-success' =>
        $variant === 'success',
    'text-skin-inverted bg-skin-danger bg-opacity-90 hover:bg-opacity-100 focus:ring-skin-danger' =>
        $variant === 'danger',
    'text-skin-inverted bg-skin-warning bg-opacity-90 hover:bg-opacity-100 focus:ring-skin-warning' =>
        $variant === 'warning',
    ...$class,
])>
    {{ $slot }}
</button>
