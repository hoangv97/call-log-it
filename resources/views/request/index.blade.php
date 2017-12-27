@extends('layouts.base')

@section('page-level-plugins.styles')
   @parent
    {{Html::style('metronic/global/plugins/datatables/datatables.min.css')}}
    {{Html::style('metronic/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}
@endsection

@section('page-level-styles')
    @parent
    {{Html::style('css/custom-badge.css')}}
@endsection

@section('page-level-plugins.scripts')
    @parent
    {{Html::script('metronic/global/scripts/datatable.js')}}
    {{Html::script('metronic/global/plugins/datatables/datatables.min.js')}}
    {{Html::script('metronic/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}
    {{Html::script('js/datatable.js')}} {{--Config datatable--}}
@endsection

@section('page-level-scripts')
    <script>
        $(document).ready(function() {

            //remove query string from url
            history.replaceState({}, null, window.location.origin + window.location.pathname);

            @if(isset($type) && isset($status))
                initTicketsTable('{{ $type }}', '{{ $status }}');
            @else
                initTicketsTable();
            @endif

            /*
            get data table by ajax
             */
            $('.btn-tickets-table').click(function () {
                $parent = $(this).parents('.type-item');
                let type = parseInt( $parent.data('type') ),
                    status = parseInt( $(this).data('status') );

                initTicketsTable(type, status);

                //change current breadcrumb item
                $('.current-breadcrumb-item').remove();
                if(type === parseInt('{{ Constant::MENU_CREATED_TICKETS }}'))
                    return;

                $('.breadcrumb').append(
                    `<li class="current-breadcrumb-item">
                        <i class="fa fa-circle" aria-hidden="true"></i>
                        <span class="active">
                            <a href="${ $(this).data('breadcrumb-href') }">${ $(this).data('breadcrumb-name') }</a>
                        </span>
                    </li>`
                )
            });

            //create new datatable
            function initTicketsTable(type = 1, status = 0) {
                let ticketsTable = '#tickets-table';

                if($.fn.DataTable.isDataTable(ticketsTable)) {
                    $(ticketsTable).DataTable().clear().destroy()
                }
                $(ticketsTable).DataTable({
                    serverSide: true,
                    ajax: {
                        url: '{{ route('tickets.api.list') }}',
                        data: {
                            type, status
                        }
                    },
                    columns: [
                        {data: 'DT_Row_Index', name: 'id', title: 'STT', searchable: false},
                        {data: 'subject', name: 'subject', title: 'Tên công việc'},
                        {data: 'priority', name: 'priority', title: 'Mức độ ưu tiên'},
                        {data: 'created_by', name: 'created_by', title: 'Người yêu cầu'},
                        {data: 'assigned_to', name: 'assigned_to', title: 'Người thực hiện'},
                        {data: 'team', name: 'team', title: 'Bộ phận IT'},
                        {data: 'deadline', name: 'deadline', title: 'Ngày hết hạn'},
                        {data: 'status', name: 'status', title: 'Trạng thái'}
                    ],
                    //hover a ticket to read it
                    rowCallback: ( row, data, index ) => {
                        row.onmouseover = function () {
                            if($(row).hasClass('bold')) {
                                let ticket_id = $(row).find('a[data-type=subject]').data('id');
                                $.get('{{ route('tickets.api.read') }}', { t: ticket_id })
                                    .done(() => {
                                        $(row).removeClass('bold');

                                        //update unread badges
                                        $typeItem = $('.status-item.active').parent().parent();
                                        let type = $typeItem.attr('data-type');
                                        let items = [];

                                        $typeItem.find('.btn-tickets-table').each(function () {
                                            items.push({ type, status: $(this).data('status') })
                                        });

                                        $.get('{{ route('tickets.api.unread') }}', { items }, data => {
                                            for (let item of data) {
                                                $badge = $typeItem
                                                    .find(`.btn-tickets-table[data-status=${item.status}]`)
                                                    .find('span.badge');
                                                if (item.count > 0)
                                                    $badge.html(item.count < 100 ? item.count : '99+');
                                                else
                                                    $badge.html('')
                                            }
                                        })
                                    })
                            }
                        }
                    }
                });

                //update caption
                let $typeItem = $(`.type-item[data-type=${type}]`);

                $('.caption-subject').html( $typeItem.data('caption') );

                //update selected menu item
                $('.btn-tickets-table').parent().removeClass('active');
                let $statusItem = $typeItem.find(`.btn-tickets-table[data-status=${status}]`);
                $statusItem.parent().addClass('active');

                //return to top
                $('html, body').animate({
                    scrollTop: 0
                }, 500)
            }
        });
    </script>
@endsection

@section('page.content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-blue sbold"></span>
        </div>
    </div>
    <div class="portlet-body">
        <table id="tickets-table" class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer"></table>
    </div>
</div>
@endsection