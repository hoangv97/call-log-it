$.fn.dataTable.ext.errMode = 'none';
$.extend(true, $.fn.dataTable.defaults, {
    processing: true,
    serverSide: true,
    language: {
        "processing": "Đang xử lý...",
        "lengthMenu": "Xem _MENU_ mục",
        "zeroRecords": "Không tìm thấy dòng nào phù hợp",
        "emptyTable": "Không có dữ liệu trong bảng",
        "info": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
        "infoEmpty": "Đang xem 0 đến 0 trong tổng số 0 mục",
        "infoFiltered": "(được lọc từ _MAX_ mục)",
        "infoPostFix": "",
        "search": "Tìm:",
        "url": "",
    },
    "lengthMenu": [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "Tất cả"] // change per page values here
    ],
});