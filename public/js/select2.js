$.fn.select2.defaults.set("theme", "bootstrap");

function initEmployeesSelect2(selector, url, minimumInputLength = 1, teamId) {
    $(selector).select2({
        width: "off",
        ajax: {
            url: url,
            dataType: 'json',
            data: function(params) {
                return {
                    q: $.trim(params.term), // search term
                    t: teamId
                }
            },
            processResults: function(data) {
                return {
                    results: data.employees
                }
            },
            cache: true
        },
        templateResult: repo =>
            `<div class='select2-result-repository clearfix'>
                <div class='select2-result-repository__avatar'><img src='${repo.avatar_url}' /></div>
                <div class='select2-result-repository__meta'>
                    <div class='select2-result-repository__title'>${repo.name}</div>
                    ${ repo.roleInTeam !== null ? `<div class='select2-result-repository__description'>${repo.roleInTeam}</div>` : '' }
                    <div class='select2-result-repository__description'>${repo.email}</div>
                </div>
            </div>`
        ,
        escapeMarkup: function(markup) {
            return markup;
        },
        minimumInputLength: minimumInputLength,
        templateSelection: repo => repo.name || repo.text,
        language: 'vi',
        placeholder: 'Chọn nhân viên',
        allowClear: true
    })
}