<div>
    @if($count > 0)
    <span class="absolute -top-2 -right-2 bg-primary-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
        {{ $count > 99 ? '99+' : $count }}
    </span>
    @endif
</div>