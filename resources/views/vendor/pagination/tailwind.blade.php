@if ($paginator->hasPages())
    <ul role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination">
        @foreach (range(1, $paginator->lastPage()) as $page)
            @if ($page == $paginator->currentPage())
                <li aria-current="page" class="page-item active">
                    <span class="page-link">{{ $page }}</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->url($page) }}" class="page-link"
                        aria-label="{{ __('Go to page :page', ['page' => $paginator->url($page)]) }}">
                        {{ $page }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
@endif
