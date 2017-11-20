@section('extended-style')
    <style>
        .tt-menu {
            top: 130% !important;
            left: -15% !important;
        }
    </style>
@show

<script>
    $(document).ready(() => {

        $('#deadline-picker').datetimepicker({
            autoclose: true,
            todayHighlight: true,
            fontAwesome: true,
            pickerPosition: 'bottom-left',
            container: '#deadline-picker',
        });



        initEmployeesSearch('#relaters-input');

        @yield('extended-script-1')


        function initEmployeesSearch(selector) {
            let employees = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '{{ route('employees.api') }}?q=%QUERY%',
                    wildcard: '%QUERY%'
                }
            });

            employees.initialize();

            $(selector).tagsinput({
                typeaheadjs: [
                    {
                        highlight: true,
                        minLength: 1
                    },
                    {
                        name: 'employees',
                        displayKey: 'name_email',
                        valueKey: 'name_email',
                        source: employees.ttAdapter(),
                        limit: 5,
                    }
                ]
            })
        }

    })

</script>

@yield('extended-script-2')