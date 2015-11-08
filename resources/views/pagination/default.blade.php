@if ($paginator->lastPage() > 1)
    <ul class="pagination">
        <!-- if actual page is not equals 1, and there is more than 5 pages then I show first page button -->
        @if ($paginator->currentPage() != 1 && $paginator->lastPage() >= 5)
            <li>
                <a class="button flat"  href="{{ $paginator->url($paginator->url(1)) }}" >
                    <<
                </a>
            </li>
        @endif

        @if($paginator->currentPage() != 1)
            <li>
                <a class="button flat" href="{{ $paginator->url($paginator->currentPage()-1) }}" >
                    <
                </a>
            </li>
        @endif

        <!-- I draw the pages... I show 2 pages back and 2 pages forward -->
        @for($i = max($paginator->currentPage()-2, 1); $i <= min(max($paginator->currentPage()-2, 1)+4,$paginator->lastPage()); $i++)
                <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a class="button flat"  href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
        @endfor

        <!-- if actual page is not equal last page then I show the forward button-->
        @if ($paginator->currentPage() != $paginator->lastPage())
            <li>
                <a class="button flat"  href="{{ $paginator->url($paginator->currentPage()+1) }}" >
                    >
                </a>
            </li>
        @endif

        <!-- if actual page is not equal last page, and there is more than 5 pages then I show last page button -->
        @if ($paginator->currentPage() != $paginator->lastPage() && $paginator->lastPage() >= 5)
            <li>
                <a class="button flat" href="{{ $paginator->url($paginator->lastPage()) }}" >
                    >>
                </a>
            </li>
        @endif
    </ul>
@endif
