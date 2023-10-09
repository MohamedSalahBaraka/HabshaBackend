@if ($paginator->hasPages())
    <nav>
        <ul class="col-12 text-center pb-4 pt-4">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item active">
                    <span class="btn_pagging">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="btn_pagging" rel="prev">
                        &lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item" @disabled(true)><span
                            class="btn_pagging">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="btn_pagging">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item"><a href="{{ $url }}"
                                    class="btn_pagging">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn_pagging">&rsaquo;</a>
                </li>
            @else
                <li class="page-item active">
                    <span aria-hidden="true" class="btn_pagging">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
