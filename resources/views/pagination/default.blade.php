@if ($paginator->lastPage() > 1)
<nav>
    <ul class="pagination">
      @for ($i = 1; $i <= $paginator->lastPage(); $i ++)
        <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
        <a class="page-link" href="{{ $paginator->url($i) }}" tabindex="-1">{{ $i }}</a>
        </li>
      @endfor
    </ul>
</nav>
@endif