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
    {{Html::style('css/custom-badge.css')}}
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
        .mt-comment-text {
            color: #606060 !important;
        }
        .content-img {
            width: 100%;
            max-width: 600px;
            border: 1px solid #ccc;
            padding: 1px;
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
    {{Html::script('js/datetimepicker.js')}}
    {{Html::script('js/tagsinput.js')}}

    @include('extends.edit-script')
@endsection

@section('page.content')
<div class="portlet light portlet-fit portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold">
                <i class="fa fa-globe" aria-hidden="true"></i>
                <span>{{ $ticket->subject }}</span>
            </span>
        </div>
        <div class="actions">
            {{--Khong the edit neu da resolved, closed hoac cancelled--}}
            @if(TicketParser::canEditTicket($ticket->status))
                <div>
                    @if(Auth::user()->hasPermissions([2, 3, 4, 5]))
                    <a href="javascript:" class="btn btn-default btn-sm" data-toggle="modal" data-target="#team-modal">
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
                                    {!! Form::select('team_id', [1 => 'IT Hà Nội', 2 => 'IT Đà Nẵng'], $ticket->team->id, ['class' => 'form-control']); !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary btn-submit-ticket-info" id="team_id-submit" data-dismiss="modal">Lưu thay đổi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->hasPermissions([2, 3, 4, 5]))
                    <a href="javascript:" class="btn btn-default btn-sm" data-toggle="modal" data-target="#priority-modal">
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
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label" for="priority">
                                                Mức độ ưu tiên
                                            </label>
                                            {!! Form::select('priority', [1 => 'Thấp', 2 => 'Bình thường', 3 => 'Cao', 4 => 'Khẩn cấp'], $ticket->priority, ['class' => 'form-control']); !!}
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="priority-reason">
                                                Lý do thay đổi
                                                <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <textarea class="wysihtml5 form-control" rows="6" required name="priority-reason" title="priority-reason"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary btn-submit-ticket-info" id="priority-submit" data-dismiss="modal">Lưu thay đổi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->hasPermissions([2, 3, 4, 5]))
                    <a href="javascript:" class="btn btn-default btn-sm" data-toggle="modal" data-target="#deadline-modal">
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
                                            <label class="control-label" for="deadline-reason">
                                                Lý do thay đổi
                                                <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <textarea class="wysihtml5 form-control" rows="6" required name="deadline-reason" title="deadline-reason"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary btn-submit-ticket-info" id="deadline-submit" data-dismiss="modal">Lưu thay đổi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->hasPermissions([2, 3, 4, 5]) || $ticket->creator->id == Auth::id())
                    <a href="javascript:" class="btn btn-default btn-sm" data-toggle="modal" data-target="#relaters-modal">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        Thay đổi người liên quan
                    </a>
                    <div class="modal fade" id="relaters-modal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                    <h4 class="modal-title">Thay đổi người liên quan</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-body">
                                        <div class="form-group">
                                            {!! Form::text('relaters', '', ['class' => 'form-control', 'id' => 'relaters']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary btn-submit-ticket-info" id="relaters-submit" data-dismiss="modal">Lưu thay đổi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->hasPermissions([2, 3, 4, 5]))
                    <a href="javascript:" class="btn btn-default btn-sm" data-toggle="modal" data-target="#assign-modal">
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
                                    <div class="form-body">
                                        <div class="form-group">
                                            {!! Form::text('assignee', '', ['class' => 'form-control', 'id' => 'assignee']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary btn-submit-ticket-info" id="assignee-submit" data-dismiss="modal">Lưu thay đổi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            @endif

            {{--Thay doi trang thai (status)--}}
            {{--Khong the thay doi neu da closed hoac cancelled--}}
            @if(TicketParser::canEditTicket($ticket->status, [5, 6]))
                {{--Nguoi tao, nguoi thuc hien, nguoi co quyen team hoac toan cong ty--}}
                @if(Auth::user()->hasPermissions([2, 3, 4, 5]) || $ticket->creator->id == Auth::id() || $ticket->assignee->id == Auth::id())
                    {{--Khong hien thi neu la nguoi thuc hien va co trang thai resolved--}}
                    @if($ticket->assignee->id == Auth::id() && $ticket->status == 3)
                    @else
                        @php
                        $buttons = [];
                        if($ticket->creator->id == Auth::id()) { //Nguoi tao
                            $buttons = [
                                1 => [6],
                                2 => [6],
                                3 => [4, 5, 6],
                                4 => [5, 6]
                            ];
                        } else if($ticket->assignee->id == Auth::id()) { //Nguoi thuc hien
                            $buttons = [
                                1 => [2],
                                2 => [3],
                                4 => [2]
                            ];
                        } else if(Auth::user()->hasPermissions([3, 5])) { //Nguoi co quyen toan cong ty
                            $buttons = [
                                1 => [2, 6],
                                2 => [3, 6],
                                3 => [4, 5, 6],
                                4 => [2, 5, 6]
                            ];
                        } else if(Auth::user()->hasPermissions([2, 4])) { //Nguoi co quyen team
                            $buttons = [
                                1 => [2],
                                2 => [3],
                                3 => [4],
                                4 => [2]
                            ];
                        }
                        @endphp
                        @if(array_key_exists($ticket->status, $buttons))
                            <div style="margin-top: 5px">
                                <div class="btn-group">
                                    <a class="btn btn-default btn-sm" href="javascript:" data-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-exchange"></i> Thay đổi trạng thái
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach($buttons[$ticket->status] as $button)
                                            {!! TicketParser::getStatus($button, 1) !!}
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="modal fade" id="closed-modal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                            <h4 class="modal-title">Đánh giá</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="control-label" for="rating">Đánh giá</label>
                                                    <div class="mt-radio-list">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="rating" value="1" checked/>Hài lòng
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="rating" value="0"/>Không hài lòng
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="closed-comment">
                                                        Bình luận
                                                        <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <textarea class="wysihtml5 form-control" rows="6" required name="closed-comment" title="closed-comment"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                            <button type="button" class="btn btn-primary btn-close-ticket" data-dismiss="modal">Lưu thay đổi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
            @endif
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
                        <span class="created_at-info">{{ $ticket->created_at }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Ngày hết hạn:</span>
                    </div>
                    <div class="col-md-6">
                        <span class="deadline-info">{{ $ticket->deadline }}</span>
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
                        <span class="creator-info">{{ $ticket->creator->name }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Người thực hiện:</span>
                    </div>
                    <div class="col-md-6">
                        <span class="assignee-info">{{ isset($ticket->assignee) ? $ticket->assignee->name : '' }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Bộ phận IT:</span>
                    </div>
                    <div class="col-md-6">
                        <span class="team-info">{{ $ticket->team->name }}</span>
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
                        <span class="priority-info">{!! $ticket->getPriority() !!}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Trạng thái:</span>
                    </div>
                    <div class="col-md-6">
                        <span class="status-info">{!! $ticket->getStatus() !!}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Người liên quan:</span>
                    </div>
                    <div class="col-md-6 relaters-info">
                        @foreach($ticket->relaters as $relater)
                            <div>{{ $relater->name }}</div>
                        @endforeach
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
                    <img src="{{ is_null($ticket->creator->avatar_url) ? '../img/default_user.png' : route('home').'/'.$ticket->creator->avatar_url }}" />
                </div>
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <span class="mt-comment-author">{{ $ticket->creator->name }}</span>
                        <span class="mt-comment-date">
                            <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $ticket->created_at }}
                        </span>
                    </div>
                    <div class="mt-comment-text">
                        {!! is_null($ticket->image_url) ? '' : "<img src='".route('home').'/'."$ticket->image_url' class='content-img'><br/><br/>" !!}
                        {!! $ticket->content !!}
                    </div>
                </div>
            </div>
            {{--comments--}}
            <div class="thread-comments">
            </div>
        </div>

        {{--Tao binh luan--}}
        {{--Nguoi tao, nguoi thuc hien, nguoi co quyen team hoac toan cong ty--}}
        @if(Auth::user()->hasPermissions([2, 3, 4, 5]) || $ticket->creator->id == Auth::id() || $ticket->assignee->id == Auth::id())
        <hr>
        <h4 style="margin-left: 17px" class="sbold"><i class="fa fa-comments-o" aria-hidden="true"></i> Bình luận</h4>
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
            <button type="button" class="btn blue btn-submit-comment">
                <i class="fa fa-comments-o" aria-hidden="true"></i>
                Gửi bình luận
            </button>
        </div>
        {!! Form::close() !!}
        @endif
    </div>
</div>
@endsection