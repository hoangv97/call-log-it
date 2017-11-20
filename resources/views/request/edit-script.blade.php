@extends('request.create-script')

@section('extended-style')
<style>
    .tt-menu {
        top: 130% !important;
        left: -3% !important;
    }
</style>
@endsection

@section('extended-script-1')

    initEmployeesSearch('#assignee')

@endsection

@section('extended-script-2')
    <script>
        $('.btn-submit-ticket-info').click(function (e) {
            e.preventDefault();
            updateInfoTicket()
        });

        $('.btn-update-status').click(function (e) {
            let status = parseInt($(this).attr('data-value')),
                id = '{{ $ticket->id }}';

            $.post('{{ route('tickets.update') }}', { id, status })
                .done(() => {
                    updateInfoTicket()
                })
        });

        function updateInfoTicket() {
            $.get('{{ route('tickets.info') }}', { id: '{{ $ticket->id }}'}, data => {
                for(let key in data) {
                    $(`.${key}-info`).html(data[key])
                }
            })
        }
    </script>
@endsection