@props(['header' => false, 'onClick' => null])

<tr @if ($onClick) wire:click="{{ $onClick }}" @endif
    {{ $attributes->class([
        'bg-white/40 dark:bg-white/[0.02] text-[10px] uppercase tracking-[0.15em] font-black text-gray-400 dark:text-gray-500' => $header,
        'group bg-transparent hover:bg-primaryColor/[0.04] dark:hover:bg-primaryColor/[0.06] transition-all duration-200 cursor-pointer border-b border-gray-100/50 dark:border-white/[0.03] last:border-b-0' => !$header,
    ]) }}>
    {{ $slot }}
</tr>
