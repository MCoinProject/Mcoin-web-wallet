@if ($paginator->hasPages())
    <div class="dataTables_paginate paging_simple_numbers pull-right">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="paginate_button previous disabled">
                    <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0">Previous</a>
                </li>
            @else
                <li class="paginate_button previous">
                    <a href="{{ $paginator->previousPageUrl() }}" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0">Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="paginate_button active">
                                <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="{{ $page }}" tabindex="0">{{ $page }}</a>
                            </li>
                        @else
                            <li class="paginate_button">
                                <a href="{{ $url }}" aria-controls="DataTables_Table_0" data-dt-idx="{{ $page }}" tabindex="0">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="paginate_button next">
                    <a href="{{ $paginator->nextPageUrl() }}" aria-controls="DataTables_Table_0" data-dt-idx="{{ count($element) }}" tabindex="0">Next</a>
                </li>
            @else
                <li class="paginate_button next disabled">
                    <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="{{ count($element) }}" tabindex="0">Next</a>
                </li>
            @endif
        </ul>
    </div>
@endif
