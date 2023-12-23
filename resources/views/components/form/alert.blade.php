@php
if ($type === 'none' && !$message) {
    if ($errors->any()) {
        $message = $errors->first();
        $type = 'error';
    } elseif(Session::has('form-alert')) {
        $message = Session::get('form-alert');
        $type = Session::get('form-alert-type', 'success');
    }
}
@endphp
@if ($message)
    <div @class([
        'text-sm px-5 py-2.5 rounded shadow-sm border',
        'text-skin-success bg-skin-success bg-opacity-10 border-skin-success' => $type == 'success',
        'text-skin-warning bg-skin-warning bg-opacity-10 border-skin-warning' => $type == 'warning',
        'text-skin-danger bg-skin-danger bg-opacity-10 border-skin-danger' => $type == 'error',
        'text-skin-neutral bg-skin-neutral bg-opacity-10 border-skin-neutral' => $type == 'none',
        ...$class,
    ])>
        {!! $message !!}
    </div>
@endif
