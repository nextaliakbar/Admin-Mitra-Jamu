@if ($paginator->hasPages())
  <ul class="pagination pagination-rounded justify-content-center mt-3 mb-4 pb-1">
    <li class="page-item {{ $paginator->previousPageUrl() ? '' : 'disabled' }}">
      <a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i class="mdi mdi-chevron-left"></i></a>
    </li>
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
      <li class="page-item {{ $i == $paginator->currentPage() ? 'active' : '' }}">
        <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
      </li>
    @endfor
    <li class="page-item {{ $paginator->nextPageUrl() ? '' : 'disabled' }}">
      <a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i class="mdi mdi-chevron-right"></i></a>
    </li>
  </ul>
@endif
