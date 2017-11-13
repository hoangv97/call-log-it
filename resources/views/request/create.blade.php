@extends('layouts.base')

@section('page-level-plugins.styles')
    @parent
    {{Html::style('metronic/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('metronic/global/plugins/select2/css/select2-bootstrap.min.css')}}
    {{--{{Html::style('metronic/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}--}}
    {{--{{Html::style('metronic/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}--}}
    {{Html::style('metronic/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}

    {{Html::style('metronic/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}

    {{Html::style('metronic/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}
    {{Html::style('metronic/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css')}}
@endsection

@section('page-level-styles')
    @parent
    {{Html::style('metronic/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}
@endsection

@section('page-level-plugins.scripts')
    @parent
{{--    {{Html::script('metronic/global/plugins/moment.min.js')}}--}}
    {{Html::script('metronic/global/plugins/select2/js/select2.full.min.js')}}
    {{Html::script('metronic/global/plugins/jquery-validation/js/jquery.validate.min.js')}}
    {{Html::script('metronic/global/plugins/jquery-validation/js/additional-methods.min.js')}}
    {{Html::script('metronic/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}
{{--    {{Html::script('metronic/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}--}}
    {{Html::script('metronic/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}

    {{Html::script('metronic/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}
    {{Html::script('metronic/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}

    {{Html::script('metronic/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}
    {{Html::script('metronic/global/plugins/typeahead/typeahead.bundle.min.js')}}
@endsection

@section('page-level-scripts')
    @parent
    {{Html::script('metronic/pages/scripts/form-validation.min.js')}}
    {{Html::script('metronic/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}

    {{Html::script('js/request/create.js')}}
@endsection

@section('page.content')
    {{--FORM--}}
<div class="portlet light portlet-fit portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-red sbold uppercase">Thêm yêu cầu</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                {!! Form::open() !!}
                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button> Your form validation is successful!
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="request">Tên công việc
                            <span class="required" aria-required="true"> * </span>
                        </label>
                        {!! Form::text('request', '', ['class' => 'form-control', 'data-required' => 1, 'placeholder' => 'Tên công việc']) !!}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="priority">
                                    Mức độ ưu tiên
                                </label>
                                {!! Form::select('priority', ['Thấp', 'Bình thường', 'Cao', 'Khẩn cấp'], 1, ['class' => 'form-control']); !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" for="deadline">Ngày hết hạn
                                    <span class="required" aria-required="true"> * </span>
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="it-department">
                                    Bộ phận IT
                                    <span class="required" aria-required="true"> * </span>
                                </label>
                                {!! Form::select('it-department', ['IT Hà Nội', 'IT Đà Nẵng'], 0, ['class' => 'form-control']); !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="related-person">
                                    Người liên quan
                                </label>
                                {!! Form::text('related-person', '', ['class' => 'form-control', 'id' => 'related-person']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="content">
                            Nội dung
                            <span class="required" aria-required="true"> * </span>
                        </label>
                        <textarea class="wysihtml5 form-control" rows="6" name="content" title="comment" data-error-container="#content_error"></textarea>
                        <div id="content_error"> </div>
                    </div>
                    <div class="form-group">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group input-large">
                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                    <span class="fileinput-filename"> </span>
                                </div>
                                <span class="input-group-addon btn default btn-file">
                                    <span class="fileinput-new"> Chọn file </span>
                                    <span class="fileinput-exists"> Đổi </span>
                                    <input type="file" name="...">
                                </span>
                                <a href="javascript:" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Xóa </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn blue">
                                <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                Gửi yêu cầu
                            </button>
                            <a href="{{ route('request.index') }}" class="btn default">
                                <i class="fa fa-ban" aria-hidden="true"></i>
                                Hủy bỏ
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection