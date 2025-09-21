<div x-data x-on:cart-updated.window="$wire.$refresh()">
    @if($this->count > 0)
    <span class="absolute -top-1 -right-1 bg-gradient-to-r from-primary-500 to-accent-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center shadow-glow font-mono">
        {{ $this->count > 99 ? '99+' : $this->count }}
    </span>
    @endif
</div>