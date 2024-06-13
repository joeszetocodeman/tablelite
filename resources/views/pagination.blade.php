@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
        class="flex items-center justify-between border-t border-gray-50 p-2">
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span></span>
            @else
                <button type="button" wire:click="gotoPage('prev')" rel="prev"
                    class="relative inline-flex items-center rounded-full p-2 font-medium leading-5 text-primary-500 transition duration-150 ease-in-out hover:bg-gray-50 focus:bg-primary-100 active:bg-primary-100 focus:outline-none">
                    <svg class="h-6 w-6 focus:outline-none" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            @endif

            @if ($paginator->hasMorePages())
                <button type="button" wire:click="gotoPage('next')" rel="next"
                    class="relative inline-flex items-center rounded-full p-2 font-medium leading-5 text-primary-500 transition duration-150 ease-in-out hover:bg-gray-50 focus:bg-primary-100 active:bg-primary-100 focus:outline-none">
                    <svg class="h-6 w-6 focus:outline-none" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            @else
                <span></span>
            @endif
        </div>

        <div class="hidden w-full flex-1 items-center justify-between sm:flex">
            <div>
                <p class="text-sm leading-5">
                    <span>{!! __('Showing') !!}</span>
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    <span>{!! __('of') !!}</span>
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    <span>{!! __('results') !!}</span>
                </p>
            </div>

            <div>
                <span
                    class="relative z-0 flex items-center gap-px divide-x divide-gray-300 rounded-md border text-sm text-gray-500 shadow-sm rtl:divide-x-reverse">
                    {{-- Previous Page Link --}}
                    @if (!$paginator->onFirstPage())
                        <button wire:click="gotoPage('prev')" rel="prev"
                            class="relative inline-flex items-center rounded-l-md px-1 py-1 text-sm font-medium leading-5 text-primary-500 transition duration-150 ease-in-out hover:bg-gray-50 active:border-primary-500 active:bg-primary-100 active:ring-1 active:ring-inset active:ring-primary-500 focus:outline-none"
                            aria-label="{{ __('pagination.previous') }}">
                            <svg class="h-5 w-5 focus:outline-none" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="relative -ml-px inline-flex cursor-default items-center px-3 py-1 text-sm font-medium leading-5 text-gray-700">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="relative -ml-px inline-flex cursor-default items-center rounded-md border-2 border-primary-500 bg-primary-100 px-3 py-1 font-semibold leading-5 text-primary-500">{{ $page }}</span>
                                    </span>
                                @else
                                    <button wire:click="gotoPage({{ $page }})"
                                        class="relative -ml-px inline-flex items-center px-3 py-1 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-50 active:border-primary-500 active:bg-primary-100 active:ring-1 active:ring-inset active:ring-primary-500 focus:outline-none"
                                        aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <button wire:click="gotoPage('next')" rel="next"
                            class="relative -ml-px inline-flex items-center rounded-r-md px-1 py-1 text-sm font-medium leading-5 text-primary-500 transition duration-150 ease-in-out hover:bg-gray-50 active:border-primary-500 active:bg-primary-100 active:ring-1 active:ring-inset active:ring-primary-500 focus:outline-none"
                            aria-label="{{ __('pagination.next') }}">
                            <svg class="h-5 w-5 focus:outline-none" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
