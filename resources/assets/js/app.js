$(document).ready(function() {
    //turns tables into sortable grids
    $('#bookDataTable').dataTable({
        "iDisplayLength": 25,
        paging: true,
        searching: false
    });
    $('.button, input:submit').button();

    $('#books_panel_show').click(function(event){
        event.preventDefault();
        $('#books_panel').show();
        $('#books_table').hide();
    }); 

    $('#books_table_show').click(function(event){
        event.preventDefault();
        $('#books_table').show();
        $('#books_panel').hide();
    });     
});

$('#books_panel_show').click(function(event){
    event.preventDefault();
    $('#books_panel').show();
    $('#books_table').hide();
}); 

$('#books_table_show').click(function(event){
    event.preventDefault();
    $('#books_table').show();
    $('#books_panel').hide();
});    