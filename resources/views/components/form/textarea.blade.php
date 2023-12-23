<div @class($class) id="{!!$groupId!!}">
    @if ($label)
    <label for="{!!$id!!}" class="mb-2 ml-1 font-bold text-xs text-skin-primary text-opacity-90">{!!$label!!}</label>
    @endif
    <textarea
        id="{!!$id!!}"
        class="text-sm leading-5.6 block w-full appearance-none rounded-lg border border-solid border-skin-neutral border-opacity-30 bg-transparent px-3 py-2 font-normal text-skin-primary transition-all focus:border-skin-accent focus:outline-none focus:shadow-input focus:shadow-skin-accent"
        placeholder="{{$placeholder??$label}}" {{$attributes}}>{{$slot}}</textarea>
    @if ($hint)
    <label
        for="{!!$id!!}"
        @class([
            "text-xs font-normal leading-normal mt-0",
            'text-red-500' => $hintType == 'error',
            'text-yellow-300' => $hintType == 'warning',
            'text-emerald-600' => $hintType == 'success',
            'text-gray-600' => $hintType == 'none'
        ])>
        {{$hint}}
    </label>
    @endif
</div>