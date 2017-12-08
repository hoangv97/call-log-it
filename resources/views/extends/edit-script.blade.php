<style>
    .tt-menu {
        top: 130% !important;
        left: -3% !important;
    }
</style>

<script>

    $(document).ready(() => {

        //init functions
        updateAllData();

        function addEvents() {
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

                //if status is closed or cancelled, open modal for user to comment, not update
                if(value === '{{ Constant::STATUS_CLOSED }}'
                    || value === '{{ Constant::STATUS_CANCELLED }}') {
                    $('#closed-modal').attr('data-status', value);
                    return
                }

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
                    type: '{{ Constant::COMMENT_NORMAL }}',
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
                    type: '{{ Constant::COMMENT_RATING }}',
                    status: $('#closed-modal').attr('data-status'),
                    _token: '{{ csrf_token() }}'
                };
                updateToServer('{{ route('thread.store') }}', data);
                $('.modal-backdrop').remove()
            });
        }

        //Update data to server then update info, comments in view
        function updateToServer(url, data) {
            $.post(url, data)
                .always(updateAllData)
        }

        /*
        update all field by ajax
        */
        function updateAllData() {
            getTicketButtons()
                .always(getTicketInfo)
                .always(getComments)
                .always(addEvents)
        }

        /*
        update info: creator, assignee, relaters, priority...
         */
        function getTicketInfo() {
            return $.get('{{ route('tickets.api.info') }}', { id: '{{ $ticket->id }}'}, data => {
                for(let key in data.info) {
                    $(`.${key}-info`).html(data.info[key])
                }
                for(let relater of data.relaters) {
                    $('input[name=relaters]').tagsinput('add', relater)
                }
            })
        }

        /*
        update buttons: change team, priority, status...
        each time user change status (close, cancel...)
        */
        function getTicketButtons() {
            return $.get('{{ route('tickets.api.edit-buttons', ['id' => $ticket->id]) }}', null, data => {
                if(data.success) {
                    $('.edit-buttons').html(data.html);

                    //run libs
                    $('.wysihtml5[name=priority-reason]').wysihtml5();
                    $('.wysihtml5[name=deadline-reason]').wysihtml5();
                    $('.wysihtml5[name=closed-comment]').wysihtml5();

                    initDatetimepicker('#deadline-picker');
                    //get current deadline
                    $('input[name=deadline]').val( $('.deadline-info').html() );

                    initEmployeesSearch('#relaters', '{{ route('employees.api.all') }}');

                    initEmployeesSearch('#assignee', '{{ route('employees.api.assignee') }}', 1); //max = 1
                }
            })
        }
        
        /*
        update comments section
         */
        function getComments() {
            return $.get('{{ route('threads.api') }}', { id: '{{ $ticket->id }}' }, response => {
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