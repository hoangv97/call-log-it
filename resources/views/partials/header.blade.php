<style>
    .page-logo a,
    .page-logo a:hover,
    .page-logo a:active {
        text-decoration: none;
    }
    .page-logo a:hover {
        color: #337ab7;
    }
    .logo-default {
        margin-top: 20px !important;
    }
</style>
<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner">
        <div class="page-logo">
            <a href="{{ route('home') }}">
                <h3 class="uppercase logo-default" style="font-size: 2em">Call Log IT</h3>
            </a>
            <div class="menu-toggler sidebar-toggler">
            </div>
        </div>
        <a href="javascript:" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
        @if(Auth::check())
            <div class="page-top">
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown dropdown-user dropdown-dark">
                            <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <span class="username username-hide-on-mobile">
                                    {!! Auth::user()->name !!}
                                </span>
                                <img alt="avatar" class="img-circle" src="@if(is_null(Auth::user()->avatar_url))../img/default_user.png @else {!! route('home').'/'.Auth::user()->avatar_url !!} @endif" />
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default" style="top: 70px">
                                <li>
                                    <a href="javascript:">
                                        <i class="icon-user"></i> Tài khoản của tôi
                                    </a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="icon-key"></i> Đăng xuất
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>