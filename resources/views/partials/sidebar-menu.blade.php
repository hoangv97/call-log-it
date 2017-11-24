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
                @php($subMenu = $subMenus[$subMenuIndex])
                <li class="nav-item start">
                    <a href="{{ Route::currentRouteName() == 'request.index' ? 'javascript:' : route('request.index', [ 't' => $menu['type'], 's' => $subMenu['status'] ]) }}" class="nav-link btn-tickets-table" data-status="{{ $subMenu['status'] }}">
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