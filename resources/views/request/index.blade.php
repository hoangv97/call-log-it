@extends('layouts.base')

@section('page-level-scripts')
    @parent
    {{Html::script('js/request/list.js')}}
@endsection

@section('page.content')
<div class="portlet light portlet-fit portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-blue sbold">
                Danh sách công việc
            </span>
        </div>
        <div class="actions">
            <a href="javascript:" class="btn btn-primary">
                Reset bộ lọc
            </a>
            <a href="javascript:" class="btn btn-primary">
                Tìm kiếm
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <!--DATATABLE-->
    </div>
</div>
@endsection