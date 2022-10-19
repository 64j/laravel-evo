<ul class="dropdown-menu {!! $itemsClass ?? '' !!}">
    @foreach($items as $item)
        @if($item == 'separator')
            <li class="col"></li>
            @continue
        @endif

        @continue(!empty($item['hidden']))

        <li class="col-auto">
            <a href="{{ $item['href'] ?? 'javascript:;' }}" class="d-block dropdown-item px-2 px-md-3 py-2" target="main">
                {!! $item['icon'] ?? '' !!}
                {!! $item['title'] ?? '' !!}
            </a>

            @if(!empty($item['items']))
                @include('manager::partials.main-menu', [
                    'itemsClass' => $item['items.class'] ?? '',
                    'items' => $item['items']
                ])
            @endif
        </li>
    @endforeach
</ul>
