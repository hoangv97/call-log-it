<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{ route('home') }}">Home</a>
        <i class="fa fa-circle" aria-hidden="true"></i>
    </li>
    <li>
        <span class="active"><a href="{{ route('home') }}">IT</a></span>
        <i class="fa fa-circle" aria-hidden="true"></i>
    </li>
    <li>
        <span class="active"><a href="{{ route('request.index') }}">Request IT</a></span>
    </li>
    @if(isset($breadcrumb))
        <li class="current-breadcrumb-item">
            <i class="fa fa-circle" aria-hidden="true"></i>
            <span class="active"><a href="{{ $breadcrumb['href'] }}">{{ $breadcrumb['name'] }}</a></span>
        </li>
    @endif
</ul>