function initEmployeesSearch(selector, url, ticketId = undefined, maxTags = undefined) {
    let employees = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: url + '?q=%QUERY%' + (ticketId !== undefined ? '&t=' + ticketId : ''),
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
                displayKey: 'name',
                valueKey: 'name',
                source: employees.ttAdapter(),
                limit: 5,
            }
        ],
        maxTags: maxTags
    })
}