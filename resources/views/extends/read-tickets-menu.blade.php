<script>
    $(document).ready(() => {

        let items = [];

        $('.type-item').each(function () {
            let type = $(this).data('type');
            $(this).find('.btn-tickets-table').each(function () {
                let status = $(this).data('status');
                items.push({ type, status });
            })
        });

        $.get('{{ route('tickets.api.unread') }}', { items }, data => {
            for (let item of data) {
                if (item.count > 0)
                    $(`.type-item[data-type=${item.type}]`)
                        .find(`.btn-tickets-table[data-status=${item.status}]`)
                        .find('span.badge')
                        .html(item.count < 100 ? item.count : '99+')
            }
        })

    });
</script>