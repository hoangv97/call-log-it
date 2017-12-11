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
        <div class="actions edit-buttons">
            {{-- call by ajax --}}
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
                        <span class="created_at-info">{{ $ticket->created_at->format(Constant::DATETIME_FORMAT) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Ngày hết hạn:</span>
                    </div>
                    <div class="col-md-6">
                        <span class="deadline-info"></span>
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
                        {!! TicketParser::getEmployeeLabel($ticket->creator) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Người thực hiện:</span>
                    </div>
                    <div class="col-md-6">
                        <span class="assignee-info"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Bộ phận IT:</span>
                    </div>
                    <div class="col-md-6">
                        <span class="team-info"></span>
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
                        <span class="priority-info"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Trạng thái:</span>
                    </div>
                    <div class="col-md-6">
                        <span class="status-info"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <span class="sbold">Người liên quan:</span>
                    </div>
                    <div class="col-md-6 relaters-info">

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
                            <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $ticket->created_at->format(Constant::DATETIME_FORMAT) }}
                        </span>
                    </div>
                    <div class="mt-comment-text">
                        {!! is_null($ticket->image_url) ? '' : "<img src='".route('home').'/'."$ticket->image_url' class='img-thumbnail'><br/><br/>" !!}
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
        @if(Auth::user()->hasPermissions(Constant::PERMISSIONS_TEAM_COMPANY) || $ticket->creator->id == Auth::id() || $ticket->assignee->id == Auth::id())
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