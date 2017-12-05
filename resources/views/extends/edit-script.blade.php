<style>
    .tt-menu {
        top: 130% !important;
        left: -3% !important;
    }
</style>

<script>

    $(document).ready(() => {

        initDatetimepicker('#deadline-picker');
        //get current deadline
        $('input[name=deadline]').val( $('.deadline-info').html() );

        initEmployeesSearch('#relaters', '{{ route('employees.api.all') }}');
        //get current relaters
        $('.relaters-info').find('div').toArray().map(div => div.innerHTML).forEach(relater => {
            $('input[name=relaters]').tagsinput('add', relater)
        });

        initEmployeesSearch('#assignee', '{{ route('employees.api.assignee') }}', 1); //max = 1

        getComments();

        //update ticket info
        $('.btn-submit-ticket-info').click(function() {
            let field = $(this).attr('id').split('-')[0],
                id = '{{ $ticket->id }}',
                value, reason;
            //Get input
            if(field === 'team_id' || field === 'priority') {
                value = $(`select[name=${field}] option:selected`).val();
            } else {
                value = $(`input[name=${field}]`).val()
            }
            //Get reason
            if(field === 'priority' || field === 'deadline') {
                reason = $(`textarea[name=${field}-reason]`).val()
            }
            //Set data to send
            let data = { id, field, value };
            if(reason !== undefined) {
                data.reason = reason;
                data.creator_id = '{{ Auth::id() }}'
            }
            //Send to server
            updateToServer('{{ route('tickets.api.update') }}', data)
        });

        //update status
        $('.btn-update-status').click(function() {
            let value = $(this).attr('data-value');

            //if status is closed, open modal for user to comment, not update
            if(value === '5') return;

            let data = {
                value,
                field: 'status',
                id: '{{ $ticket->id }}'
            };

            updateToServer('{{ route('tickets.api.update') }}', data)
        });

        //submit comment
        $('.btn-submit-comment').click(function () {
            let data = {
                content: $('textarea[name=comment]').val(),
                ticket_id: '{{ $ticket->id }}',
                type: 0,
                _token: '{{ csrf_token() }}'
            };
            updateToServer('{{ route('thread.store') }}', data)
        });
        
        //close ticket
        $('.btn-close-ticket').click(function () {
            let data = {
                rating: $('input[name=rating]:checked').val(),
                content: $('textarea[name=closed-comment]').val(),
                ticket_id: '{{ $ticket->id }}',
                type: 1,
                _token: '{{ csrf_token() }}'
            };
            updateToServer('{{ route('thread.store') }}', data)
        });

        //Update data to server then update info, comments in view
        function updateToServer(url, data) {
            $.post(url, data)
                .done(getTicketInfo)
                .done(getComments)
        }

        function getTicketInfo() {
            $.get('{{ route('tickets.api.info') }}', { id: '{{ $ticket->id }}'}, data => {
                for(let key in data) {
                    $(`.${key}-info`).html(data[key])
                }
            })
        }

        function getComments() {
            $.get('{{ route('threads.api') }}', { id: '{{ $ticket->id }}' }, response => {
                $('.thread-comments').html('');
                $('textarea[name=comment]').data("wysihtml5").editor.setValue('');

                response.forEach(thread => {
                    $('.thread-comments').append(
                        `<div class="mt-comment">
                            <div class="mt-comment-img">
                                <img src="${thread.creator.avatar_url}" />
                            </div>
                            <div class="mt-comment-body">
                                <div class="mt-comment-info">
                                    <span class="mt-comment-author">${thread.creator.name}</span>
                                    <span class="mt-comment-date">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i> ${thread.created_at}
                                    </span>
                                </div>
                                <div class="mt-comment-text">${thread.content}</div>
                            </div>
                        </div>`
                    )
                });
            })
        }
    })
</script>