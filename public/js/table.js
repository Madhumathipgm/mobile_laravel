"use strict";
$(document).ready(function () {
    let table = $("#modelsTable").DataTable({
        fixedHeader: true,
        colReorder: true,
        responsive: true,
        pageLength: 17,
    });
    $("a.toggle-vis").on("click", function (e) {
        e.preventDefault();
        let column = table.column($(this).attr("data-column"));
        column.visible(!column.visible());
    });
});
$(document).ready(function () {
    $("#package").DataTable({
        fixedHeader: true,
        colReorder: true,
        responsive: true,
        bPaginate: false,
        bInfo: false,
        bFilter: false,
        bSort: false,
    });
});
$(document).ready(function () {
    $("#attributes").DataTable({
        fixedHeader: true,
        colReorder: true,
        responsive: true,
        bPaginate: false,
        bInfo: false,
        bFilter: false,
        bSort: false,
    });
});
$(document).ready(function () {
    $("#categories").DataTable({
        fixedHeader: true,
        colReorder: true,
        responsive: true,
        pageLength: 3,
    });
});
$(document).ready(function () {
    $("#carSeals").DataTable({
        fixedHeader: true,
        colReorder: true,
        responsive: true,
        pageLength: 8,
    });
});
$(document).ready(function () {
    $("#features").DataTable({
        fixedHeader: true,
        colReorder: true,
        responsive: true,
        pageLength: 2,
    });
});
