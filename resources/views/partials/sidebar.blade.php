<style>
    .sub-menu .nav-link {
        padding: 5px 14px 5px 30px !important;
    }
</style>
@php
    $subMenus = [
        [
            'title' => 'All',
            'status' => 0,
            'badge' => 'success',
            'icon' => 'inbox'
        ],
        [
            'title' => 'New',
            'status' => 1,
            'badge' => 'warning',
            'icon' => 'envelope-o'
        ],
        [
            'title' => 'Inprogress',
            'status' => 2,
            'badge' => 'success',
            'icon' => 'hourglass-half'
        ],
        [
            'title' => 'Resolved',
            'status' => 3,
            'badge' => 'success',
            'icon' => 'registered'
        ],
        [
            'title' => 'Feedback',
            'status' => 4,
            'badge' => 'success',
            'icon' => 'reply-all'
        ],
        [
            'title' => 'Closed',
            'status' => 5,
            'badge' => 'danger',
            'icon' => 'minus-circle'
        ],
        [
            'title' => 'Out Of Date',
            'status' => 7,
            'badge' => 'danger',
            'icon' => 'calendar-times-o'
        ],
    ];

    $menus = [
        [
            'title' => 'Việc tôi yêu cầu',
            'subMenuIndices' => [0, 1, 2, 3, 6],
            'icon' => 'user',
            'caption' => 'Danh sách công việc yêu cầu',
            'type' => 1
        ],
        [
            'title' => 'Công việc liên quan',
            'subMenuIndices' => [0, 1, 2, 3, 6],
            'icon' => 'list',
            'caption' => 'Danh sách công việc liên quan',
            'type' => 2
        ],
        [
            'title' => 'Việc tôi được giao',
            'subMenuIndices' => [0, 1, 2, 4, 6],
            'icon' => 'th-list',
            'caption' => 'Danh sách công việc được giao',
            'type' => 3
        ],
        [
            'title' => 'Công việc của team',
            'subMenuIndices' => [0, 1, 2, 4, 5, 6],
            'icon' => 'users',
            'caption' => 'Danh sách công việc của team',
            'type' => 4
        ],
        [
            'title' => 'Công việc của bộ phận IT',
            'subMenuIndices' => [0, 1, 2, 4, 5, 6],
            'icon' => 'users',
            'caption' => 'Danh sách công việc của bộ phận IT',
            'type' => 5
        ]
    ];

    $userMenus = [ 0, 1 ]; //cong viec yeu cau + cong viec lien quan
    if(Auth::user()->hasPermissions([1, 2, 3])) //cong viec duoc giao
        $userMenus[] = 2;
    if(Auth::user()->hasPermissions([2, 4])) //cong viec cua team
        $userMenus[] = 3;
    if(Auth::user()->hasPermissions([3, 5])) //cong viec cua bo phan it
        $userMenus[] = 4;

@endphp
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        @foreach($userMenus as $menuIndex)
            @component('partials.sidebar-menu', [ 'menu' => $menus[$menuIndex], 'subMenus' => $subMenus ])
            @endcomponent
        @endforeach
    </div>
</div>