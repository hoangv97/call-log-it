<style>
    .tt-menu {
        top: 130% !important;
        left: -3% !important;
    }
</style>

<script>

    $(document).ready(() => {

        let contentSelector = '.ticket-content';

        //init functions
        blockUI(contentSelector);
        updateAllData();

        //submit comment by button
        $('.btn-submit-comment').click(function () {
            let comment = $('textarea[name=comment]').val();
            if(comment === null || comment === '')
                return;

            let data = {
                content: comment,
                ticket_id: '{{ $ticket->id }}',
                type: '{{ Constant::COMMENT_NORMAL }}',
                _token: '{{ csrf_token() }}'
            };
            updateToServer('{{ route('thread.store') }}', data)
        });


        /*
        update all field by ajax
        add block ui for sync ajax
        */
        function updateAllData() {
            $('.modal-backdrop').remove();

            //ajax
            $.when(getTicketButtons(), getTicketInfo(), getComments())
                .then(() => {
                    addEvents();
                    unblockUI(contentSelector)
                })
        }

        //Update data to server then update info, comments in view
        function updateToServer(url, data) {
            blockUI(contentSelector);

            $.post(url, data)
                .done(response => {
                    if (response.success !== undefined) {
                        if (response.success) {
                            toastr.success('', response.detail)
                        } else {
                            toastr.error(response.detail, 'Đã xảy ra lỗi')
                        }
                    }
                })
                .done(updateAllData)
        }

        //add events for buttons
        function addEvents() {
            //update ticket info
            $('.btn-submit-ticket-info').click(function() {
                let field = $(this).attr('id').split('-')[0],
                    id = '{{ $ticket->id }}',
                    value, reason;

                //Get input
                if(field === 'team_id' || field === 'priority') {
                    value = $(`select[name=${field}] option:selected`).val()
                } else if(field === 'relaters[]' || field === 'assignee') {
                    value = $(`select[name="${field}"]`).select2('val')
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
                let value = $(this).data('value');

                //if status is closed or cancelled, open modal for user to comment, not update
                if(value === '{{ Constant::STATUS_CLOSED }}'
                    || value === '{{ Constant::STATUS_CANCELLED }}') {
                    $('#closed-modal').data('status', value);
                    return
                }

                let data = {
                    value,
                    field: 'status',
                    id: '{{ $ticket->id }}'
                };

                updateToServer('{{ route('tickets.api.update') }}', data)
            });

            //close ticket
            $('.btn-close-ticket').click(function () {
                let data = {
                    rating: $('input[name=rating]:checked').val(),
                    content: $('textarea[name=closed-comment]').val(),
                    ticket_id: '{{ $ticket->id }}',
                    type: '{{ Constant::COMMENT_RATING }}',
                    status: $('#closed-modal').data('status'),
                    _token: '{{ csrf_token() }}'
                };
                updateToServer('{{ route('thread.store') }}', data)
            })
        }

        /*
        update info: creator, assignee, relaters, priority...
         */
        function getTicketInfo() {
            return $.get('{{ route('tickets.api.info') }}', { id: '{{ $ticket->id }}'}, data => {
                for(let key in data.info) {
                    $(`.${key}-info`).html(data.info[key])
                }

                //update relaters to select form
                let relatersSelect = $('#relaters');
                for(let relater of data.relaters) {
                    let newOption = new Option(relater.name, relater.id, true, true);
                    relatersSelect.append(newOption).trigger('change');
                    relatersSelect.trigger({
                        type: 'select2:select',
                        params: {
                            data: data.relater
                        }
                    })
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

                    initEmployeesSelect2('#relaters', '{{ route('employees.api.all') }}');

                    initEmployeesSelect2('#assignee', '{{ route('employees.api.assignee') }}', 0, '{{ $ticket->team->id }}')
                }
            })
        }
        
        /*
        update comments section
         */
        function getComments() {
            return $.get('{{ route('threads.api') }}', { id: '{{ $ticket->id }}' }, response => {
                $('.thread-comments').html(response.html);

                $commentArea = $('textarea[name=comment]');
                if($commentArea.data("wysihtml5"))
                    $commentArea.data("wysihtml5").editor.setValue('')
            })
        }

        /*
        block & unblock target to show ajax
         */
        function blockUI(target) {
            App.blockUI({
                target: target,
                animate: true
            })
        }

        function unblockUI(target) {
            App.unblockUI(target)
        }
    })
</script>