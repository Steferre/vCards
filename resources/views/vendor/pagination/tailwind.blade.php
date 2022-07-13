@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        <div style="margin-bottom: 15px;">
            <p class="text-sm text-gray-700 leading-5">
                <span class="font-medium">{{ $paginator->firstItem() }}</span>/<span class="font-medium">{{ $paginator->lastItem() }}</span> di <span class="font-medium">{{ $paginator->total() }}</span>
            </p>
        </div>
        <div style="display: flex;">
            @if ($paginator->onFirstPage())
                <span>
                    <
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" style="margin-right:10px;">
                    < INDIETRO
                </a>
            @endif

            <!--blocco che attiva la visualizzazione dei numeri di pagina-->
            <div>
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span>{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" style="margin: 0 10px;">
                                    <span>{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $url }}" style="margin: 0 10px;">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" style="margin-left:10px;">
                    AVANTI >
                </a>
            @else
                <span>
                    >
                </span>
            @endif
        </div>
    </nav>
@endif
