@extends('layouts.base')

@section('page-level-plugins.styles')
    @parent
    {{Html::style('metronic/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('metronic/global/plugins/select2/css/select2-bootstrap.min.css')}}
    {{Html::style('metronic/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}
    {{Html::style('metronic/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}
@endsection

@section('page-level-styles')
    @parent
    {{Html::style('metronic/global/plugins/jquery-file-upload/css/jquery.fileupload.css')}}
    {{Html::style('metronic/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css')}}
@endsection

@section('page-level-plugins.scripts')
    @parent
    {{Html::script('metronic/global/plugins/select2/js/select2.full.min.js')}}
    {{Html::script('metronic/global/plugins/jquery-validation/js/jquery.validate.min.js')}}
    {{Html::script('metronic/global/plugins/jquery-validation/js/additional-methods.min.js')}}
    {{Html::script('metronic/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}
    {{Html::script('metronic/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}
    {{Html::script('metronic/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}
    {{Html::script('metronic/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}
{{--
    {{Html::script('metronic/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js')}}
    {{Html::script('metronic/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js')}}
    {{Html::script('metronic/global/plugins/jquery-file-upload/js/vendor/load-image.min.js')}}
    {{Html::script('metronic/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js')}}
    {{Html::script('metronic/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js')}}
    {{Html::script('metronic/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js')}}
    {{Html::script('metronic/global/plugins/jquery-file-upload/js/jquery.fileupload.js')}}
    {{Html::script('metronic/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js')}}
    {{Html::script('metronic/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js')}}
    {{Html::script('metronic/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js')}}
    {{Html::script('metronic/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js')}}--}}
@endsection

@section('page-level-scripts')
    @parent
    {{Html::script('metronic/pages/scripts/form-validation.min.js')}}
    {{--{{Html::script('metronic/pages/scripts/form-fileupload.min.js')}}--}}
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
            <div class="col-md-11">
                {!! Form::open(['class' => 'form-horizontal']) !!}
                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button> Your form validation is successful!
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="job">Tên công việc
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            {!! Form::text('job', '', ['class' => 'form-control', 'placeholder' => 'Tên công việc']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6" for="priority">
                                    Mức độ ưu tiên
                                </label>
                                <div class="col-md-6">
                                    {!! Form::select('priority', ['Thấp', 'Bình thường', 'Cao', 'Khẩn cấp'], 1, ['class' => 'form-control']); !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-md-6" for="job">Ngày hết hạn
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control" title="date" readonly name="datepicker">
                                        <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="control-label col-md-6" for="priority">
                                    Bộ phận IT
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    {!! Form::select('priority', ['IT Hà Nội', 'IT Đà Nẵng'], 0, ['class' => 'form-control']); !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="control-label col-md-6" for="">
                                    Người liên quan
                                </label>
                                <div class="col-md-6">
                                    {!! Form::text('', '', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="priority">
                            Nội dung
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            <textarea class="wysihtml5 form-control" rows="6" name="content" title="comment" data-error-container="#content_error"></textarea>
                            <div id="content_error"> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-3">
                        <span class="btn green fileinput-button">
                            <i class="fa fa-plus"></i>
                            <span> Add files... </span>
                            <input type="file" name="image">
                        </span>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn blue">
                                <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                Gửi yêu cầu
                            </button>
                            <button type="button" class="btn default">
                                <i class="fa fa-ban" aria-hidden="true"></i>
                                Hủy bỏ
                            </button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection