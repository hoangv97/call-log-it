{{--Khong the edit neu da resolved, closed hoac cancelled--}}
@if(TicketParser::canEditTicket($ticket->status))
    <div>
        @if(Auth::user()->hasPermissions(Constant::PERMISSIONS_TEAM_COMPANY))
            <a href="javascript:" class="btn btn-default btn-sm" data-toggle="modal" data-target="#team-modal">
                <i class="fa fa-users font-red-flamingo" aria-hidden="true"></i>
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

        @if(Auth::user()->hasPermissions(Constant::PERMISSIONS_TEAM_COMPANY))
            <a href="javascript:" class="btn btn-default btn-sm" data-toggle="modal" data-target="#priority-modal">
                <i class="fa fa-pencil-square-o font-red-flamingo" aria-hidden="true"></i>
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

        @if(Auth::user()->hasPermissions(Constant::PERMISSIONS_TEAM_COMPANY))
            <a href="javascript:" class="btn btn-default btn-sm" data-toggle="modal" data-target="#deadline-modal">
                <i class="fa fa-calendar font-red-flamingo" aria-hidden="true"></i>
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

        @if(Auth::user()->hasPermissions(Constant::PERMISSIONS_TEAM_COMPANY) || $ticket->creator->id == Auth::id())
            <a href="javascript:" class="btn btn-default btn-sm" data-toggle="modal" data-target="#relaters-modal">
                <i class="fa fa-user font-red-flamingo" aria-hidden="true"></i>
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

        @if(Auth::user()->hasPermissions(Constant::PERMISSIONS_TEAM_COMPANY))
            <a href="javascript:" class="btn btn-default btn-sm" data-toggle="modal" data-target="#assign-modal">
                <i class="fa fa-hand-o-right font-red-flamingo" aria-hidden="true"></i>
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
@if(TicketParser::canEditTicket($ticket->status, [Constant::STATUS_CLOSED, Constant::STATUS_CANCELLED]))
    {{--Nguoi tao, nguoi thuc hien, nguoi co quyen team hoac toan cong ty--}}
    @if(Auth::user()->hasPermissions(Constant::PERMISSIONS_TEAM_COMPANY) || $ticket->creator->id == Auth::id() || $ticket->assignee->id == Auth::id())
        {{--Khong hien thi neu la nguoi thuc hien va co trang thai resolved--}}
        @if($ticket->assignee->id == Auth::id() && $ticket->status == Constant::STATUS_RESOLVED)
        @else
            @if(array_key_exists($ticket->status, $buttons))
                <div style="margin-top: 5px">
                    <div class="btn-group">
                        <a class="btn btn-default btn-sm" href="javascript:" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-exchange font-blue-steel"></i> Thay đổi trạng thái
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($buttons[$ticket->status] as $button)
                                {!! TicketParser::getStatus($button, 1) !!}
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="modal fade" id="closed-modal" tabindex="-1" data-status="{{ Constant::STATUS_CLOSED }}" role="dialog" aria-hidden="true">
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