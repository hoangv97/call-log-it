@extends('layouts.base')

@section('page-level-plugins.styles')
   {{--@parent--}}
    {{Html::style('metronic/global/plugins/datatables/datatables.min.css')}}
    {{Html::style('metronic/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}
@endsection

@section('page-level-plugins.scripts')
    {{--@parent--}}
    {{Html::script('metronic/global/scripts/datatable.js')}}
    {{Html::script('metronic/global/plugins/datatables/datatables.min.js')}}
    {{Html::script('metronic/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}
    {{Html::script('js/datatable.js')}} {{--Config datatable--}}
@endsection

@section('page-level-scripts')
    <script>
        $(document).ready(function() {

            initRequestsTable('{{ route('requests.test') }}');

            function initRequestsTable(url) {
                $('#requests-table').dataTable({
                    serverSide: true,
                    ajax: {
                        url: url,
                    },
                    columns: [
                        {data: 'id', name: 'id', title: 'STT', searchable: false},
                        {data: 'subject', name: 'subject', title: 'Tên công việc'},
                        {data: 'priority', name: 'priority', title: 'Mức độ ưu tiên'},
                        {data: 'created_by', name: 'created_by', title: 'Người yêu cầu'},
                        {data: 'assigned_to', name: 'assigned_to', title: 'Người thực hiện'},
                        {data: 'team', name: 'team', title: 'Bộ phận IT'},
                        {data: 'deadline', name: 'deadline', title: 'Ngày hết hạn'},
                        {data: 'status', name: 'status', title: 'Trạng thái'}
                    ],
                    rowCallback: ( row, data, index ) => {
                        //todo check read requests
                        if ( data.id === 1 || data.id === 6) {
                            row.classList.add('bold');
                            row.onmouseover = function () {
                                if(row.className.includes('bold')) {
                                    row.classList.remove('bold')
                                }
                                //todo save read request to server
                            }
                        }
                    },
                });
            }
        });
    </script>
@endsection

@section('page.content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-blue sbold">
                Danh sách công việc
            </span>
        </div>
        {{--<div class="actions">
            <div class="btn-group btn-group-devided" data-toggle="buttons">
                <a href="javascript:" class="btn btn-primary">
                    Reset bộ lọc
                </a>
                <a href="javascript:" class="btn btn-primary">
                    Tìm kiếm
                </a>
            </div>
        </div>--}}
    </div>
    <div class="portlet-body">
        <table id="requests-table" class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer">

        </table>
    </div>
</div>
@endsection