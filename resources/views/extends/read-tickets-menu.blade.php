<script>
    $(document).ready(() => {

        $('.type-item').each(function() {
            let type = $(this).attr('data-type');
            $(this).find('.btn-tickets-table').each(function () {
                let status = $(this).attr('data-status');
                $.get('{{ route('tickets.unread') }}', { type, status }, data => {
                    if(data > 0)
                        $(this).find('span.badge').html(data)
                })
            })
        })

    });
</script>