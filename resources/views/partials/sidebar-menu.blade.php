<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <li class="nav-item start active open type-item" data-caption="{{ $menu['caption'] }}" data-type="{{ $menu['type'] }}">
        <a href="javascript:" class="nav-link nav-toggle">
            <i class="fa fa-{{ $menu['icon'] }}" aria-hidden="true"></i>
            <span class="title" style="font-size: small">{{ $menu['title'] }}</span>
            <span class="selected"></span>
            <span class="arrow open"></span>
        </a>
        <ul class="sub-menu">
            @foreach($menu['subMenuIndices'] as $subMenuIndex)
                @php
                    $subMenu = $subMenus[$subMenuIndex];
                    $isIndexPage = Route::currentRouteName() == 'request.index';
                    $href = route('request.index', [ 't' => $menu['type'], 's' => $subMenu['status'] ]);
                @endphp
                <li class="nav-item start status-item">
                    <a class="nav-link btn-tickets-table"
                       href="{{ $isIndexPage ? 'javascript:' : $href }}"
                       data-status="{{ $subMenu['status'] }}"
                    @if($isIndexPage)
                        data-breadcrumb-href="{{ $href }}" data-breadcrumb-name="{{ TicketParser::getBreadcrumb($menu['type'], true) }}"
                    @endif
                    >
                        <i class="fa fa-{{ $subMenu['icon'] }}" aria-hidden="true"></i>
                        <span class="title">{{ $subMenu['title'] }}</span>
                        <span class="selected"></span>
                        <span class="badge badge-{{ $subMenu['badge'] }}"></span>
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
</ul>