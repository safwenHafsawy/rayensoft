@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'mt-2 space-y-2']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-start gap-3 bg-red-50 border border-red-100 text-red-700 px-3 py-2 rounded-xl text-xs shadow-sm">
                {{-- small error icon --}}
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.257 3.099c.366-.772 1.42-.772 1.786 0l6.518 13.754A1 1 0 0 1 15.686 18H4.314a1 1 0 0 1-.875-1.147L8.257 3.1zM11 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1-5a.9.9 0 0 0-.9.9v2.2c0 .5.4.9.9.9s.9-.4.9-.9v-2.2A.9.9 0 0 0 10 9z" clip-rule="evenodd" />
                </svg>

                <span class="leading-tight">
                    {{ $message }}
                </span>
            </li>
        @endforeach
    </ul>
@endif
