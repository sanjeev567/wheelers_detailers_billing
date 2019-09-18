$('#customer-list-table').DataTable({
    select: true,
    dom: 'Bfrtip',
    buttons: [
        $.extend( true, {}, {
            extend: 'excelHtml5', footer: true,
            messageTop: $('#partyName').html()
        } )
    ],
});