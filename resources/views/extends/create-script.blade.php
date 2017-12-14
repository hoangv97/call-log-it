<style>
    .tt-menu {
        top: 130% !important;
        left: -15% !important;
    }
</style>

<script>
    $(document).ready(() => {

        initDatetimepicker('#deadline-picker');

        initEmployeesSelect2('#relaters', '{{ route('employees.api.all') }}');

    })
</script>