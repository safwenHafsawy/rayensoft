@if ($paginator->hasPages())
    <nav class="flex flex-col items-end space-y-2">
        <ul class="flex items-center space-x-1">

            {{-- Previous Page --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="flex items-center justify-center px-3 py-1 text-gray-400 dark:text-gray-500 text-sm cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                        </svg>
                    </span>
                </li>
            @else
                <li>
                    <button wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            class="flex items-center justify-center px-3 py-1 text-gray-700 dark:text-gray-300 text-sm hover:text-gray-900 dark:hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                        </svg>
                    </button>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="px-2 text-gray-400 dark:text-gray-500 text-sm select-none">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="flex items-center justify-center px-3 py-1 text-white bg-primaryColor dark:bg-primaryColor rounded text-sm">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <button wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                        class="flex items-center justify-center px-3 py-1 text-gray-700 dark:text-gray-300 text-sm hover:text-gray-900 dark:hover:text-white transition-colors">
                                    {{ $page }}
                                </button>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page --}}
            @if ($paginator->hasMorePages())
                <li>
                    <button wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            class="flex items-center justify-center px-3 py-1 text-gray-700 dark:text-gray-300 text-sm hover:text-gray-900 dark:hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>
                </li>
            @else
                <li>
                    <span class="flex items-center justify-center px-3 py-1 text-gray-400 dark:text-gray-500 text-sm cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </span>
                </li>
            @endif
        </ul>

        {{-- Summary --}}
        <p class="text-xs font-body text-gray-500 dark:text-gray-400 mt-1">
            Showing <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $paginator->firstItem() }}</span> to
            <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $paginator->lastItem() }}</span> of
            <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $paginator->total() }}</span> results
        </p>
    </nav>
@endif
