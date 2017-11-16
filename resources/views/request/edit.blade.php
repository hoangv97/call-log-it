@extends('layouts.base')

@section('page-level-plugins.styles')
    @parent
    {{Html::style('metronic/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}
    {{Html::style('metronic/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}
    {{Html::style('metronic/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css')}}
{{--    {{Html::style('metronic/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}--}}
    {{Html::style('metronic/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}
@endsection

@section('page-level-styles')
    <style>
        .request-details .d-line {
            margin-top: 25px;
            margin-bottom: 25px;
        }
        .mt-comment-img img {
            width: 41px;
            height: 41px;
            border: 1px solid #ccc;
            padding: 2px;
        }
    </style>
@endsection

@section('page-level-plugins.scripts')
    @parent
    {{Html::script('metronic/global/plugins/jquery-validation/js/jquery.validate.min.js')}}
    {{Html::script('metronic/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}
    {{Html::script('metronic/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}
    {{Html::script('metronic/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}
    {{Html::script('metronic/global/plugins/typeahead/typeahead.bundle.min.js')}}
    {{Html::script('metronic/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}
    {{--{{Html::script('metronic/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}--}}
    {{Html::script('metronic/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}
@endsection

@section('page-level-scripts')
    @parent
    {{Html::script('js/form-validation.min.js')}}

    @include('request.edit-script')
@endsection

@section('page.content')
<div class="portlet light portlet-fit portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold">
                <i class="fa fa-globe" aria-hidden="true"></i>
                <span> Test</span>
            </span>
        </div>
        <div class="actions">
            <div>
                <a href="javascript:" class="btn btn-default btn-sm" id="team" data-toggle="modal" data-target="#team-modal">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    Thay đổi bộ phận IT
                </a>
                <div class="modal fade" id="team-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <h4 class="modal-title">Thay đổi bộ phận IT</h4>
                            </div>
                            <div class="modal-body">
                                {!! Form::open() !!}
                                {!! Form::select('team', ['IT Hà Nội', 'IT Đà Nẵng'], 0, ['class' => 'form-control']); !!}
                                {!! Form::close() !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary">Lưu thay đổi</button>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript:" class="btn btn-default btn-sm" id="priority" data-toggle="modal" data-target="#priority-modal">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    Thay đổi mức độ ưu tiên
                </a>
                <div class="modal fade" id="priority-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <h4 class="modal-title">Thay đổi mức độ ưu tiên</h4>
                            </div>
                            <div class="modal-body">
                                {!! Form::open() !!}
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label" for="priority">
                                            Mức độ ưu tiên
                                        </label>
                                        {!! Form::select('priority', ['Thấp', 'Bình thường', 'Cao', 'Khẩn cấp'], 1, ['class' => 'form-control']); !!}
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="priority-reason">
                                            Lý do thay đổi
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <textarea class="wysihtml5 form-control" rows="6" name="priority-reason" title="priority-reason"></textarea>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary">Lưu thay đổi</button>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript:" class="btn btn-default btn-sm" id="deadline" data-toggle="modal" data-target="#deadline-modal">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    Thay đổi deadline
                </a>
                <div class="modal fade" id="deadline-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <h4 class="modal-title">Thay đổi deadline</h4>
                            </div>
                            <div class="modal-body">
                                {!! Form::open() !!}
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label" for="deadline">
                                            Deadline
                                        </label>
                                        <div id="deadline-picker" class="input-group date form_datetime bs-datetime">
                                            <input type="text" title="datetime" readonly name="deadline" size="16" class="form-control">
                                            <span class="input-group-addon">
                                                <button class="btn default date-set" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="priority-reason">
                                            Lý do thay đổi
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <textarea class="wysihtml5 form-control" rows="6" name="priority-reason" title="priority-reason"></textarea>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary">Lưu thay đổi</button>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript:" class="btn btn-default btn-sm" id="related-person" data-toggle="modal" data-target="#related-person-modal">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    Thay đổi người liên quan
                </a>
                <div class="modal fade" id="related-person-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <h4 class="modal-title">Thay đổi người liên quan</h4>
                            </div>
                            <div class="modal-body">
                                {!! Form::open() !!}
                                <div class="form-body">
                                    <div class="form-group">
                                        {!! Form::text('related-person', '', ['class' => 'form-control', 'id' => 'related-person-input']) !!}
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary">Lưu thay đổi</button>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript:" class="btn btn-default btn-sm" id="assign" data-toggle="modal" data-target="#assign-modal">
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                    Assign
                </a>
                <div class="modal fade" id="assign-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                <h4 class="modal-title">Assign</h4>
                            </div>
                            <div class="modal-body">
                                <div class="search-bar">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="text" id="search-employee" class="form-control" placeholder="Tìm nhân viên...">
                                                <span class="input-group-btn">
                                                    <button class="btn blue uppercase bold" type="button">
                                                        <i class="fa fa-search" aria-hidden="true"></i>
                                                        Tìm kiếm
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary">Lưu thay đổi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top: 5px">
                <div class="btn-group">
                    <a class="btn btn-default btn-sm" href="javascript:" data-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-exchange"></i> Thay đổi trạng thái
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript:">
                                <i class="fa fa-envelope-o"></i> New
                            </a>
                        </li>
                        <li>
                            <a href="javascript:">
                                <i class="fa fa-hourglass-half"></i> Inprogress
                            </a>
                        </li>
                        <li>
                            <a href="javascript:">
                                <i class="fa fa-registered"></i> Resolved
                            </a>
                        </li>
                        <li>
                            <a href="javascript:">
                                <i class="fa fa-reply-all"> </i> Feedback
                            </a>
                        </li>
                        <li>
                            <a href="javascript:">
                                <i class="fa fa-minus-circle"></i> Closed
                            </a>
                        </li>
                        <li>
                            <a href="javascript:">
                                <i class="fa fa-ban"></i> Cancelled
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="portlet-body request-details">
        <div class="row d-line">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Ngày tạo:</span>
                    </div>
                    <div class="col-md-6">
                        <span>12341234</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Ngày hết hạn:</span>
                    </div>
                    <div class="col-md-6">
                        <span>123192831</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-line">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Người yêu cầu:</span>
                    </div>
                    <div class="col-md-6">
                        <span>123192831</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Người thực hiện:</span>
                    </div>
                    <div class="col-md-6">
                        <span>123192831</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Bộ phận IT:</span>
                    </div>
                    <div class="col-md-6">
                        <span>123192831</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-line">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Mức độ ưu tiên:</span>
                    </div>
                    <div class="col-md-6">
                        <span>123192831</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Trạng thái:</span>
                    </div>
                    <div class="col-md-6">
                        <span>123192831</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Người liên quan:</span>
                    </div>
                    <div class="col-md-6">
                        <span>123192831</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="portlet light portlet-fit portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span> Nội dung</span>
            </span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="mt-comments">
            <div class="mt-comment">
                <div class="mt-comment-img">
                    <img src="../img/default_user.png" />
                </div>
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <span class="mt-comment-author">Michael Baker</span>
                        <span class="mt-comment-date">26 Feb, 10:30AM</span>
                    </div>
                    <div class="mt-comment-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. </div>
                </div>
            </div>
            <div class="mt-comment">
                <div class="mt-comment-img">
                    <img src="../img/default_user.png" />
                </div>
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <span class="mt-comment-author">Larisa Maskalyova</span>
                        <span class="mt-comment-date">12 Feb, 08:30AM</span>
                    </div>
                    <div class="mt-comment-text"> It is a long established fact that a reader will be distracted. </div>
                </div>
            </div>
            <div class="mt-comment">
                <div class="mt-comment-img">
                    <img src="../img/default_user.png" />
                </div>
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <span class="mt-comment-author">Natasha Kim</span>
                        <span class="mt-comment-date">19 Dec, 09:50 AM</span>
                    </div>
                    <div class="mt-comment-text"> The generated Lorem or non-characteristic Ipsum is therefore or non-characteristic. </div>
                </div>
            </div>
            <div class="mt-comment">
                <div class="mt-comment-img">
                    <img src="../img/default_user.png" />
                </div>
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <span class="mt-comment-author">Sebastian Davidson</span>
                        <span class="mt-comment-date">10 Dec, 09:20 AM</span>
                    </div>
                    <div class="mt-comment-text"> The standard chunk of Lorem or non-characteristic Ipsum used since the 1500s or non-characteristic. </div>
                </div>
            </div>
        </div>

        <hr>
        <h4 style="margin-left: 17px" class="sbold">Bình luận</h4>
        {!! Form::open(['class' => 'form-horizontal']) !!}
        <div class="form-body">
            <div class="form-group">
                <div class="col-md-12">
                    <textarea class="wysihtml5 form-control" rows="6" name="comment" title="comment" data-error-container="#content_error"></textarea>
                    <div id="content_error"> </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">
                <i class="fa fa-comments-o" aria-hidden="true"></i>
                Gửi bình luận
            </button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection