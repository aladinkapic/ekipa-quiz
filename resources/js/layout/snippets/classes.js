$(document).ready(function (){

    /*
     *  Datepicker function -- just add class name as .datepicker
     */

    $( function() {
        $( ".datepicker" ).datepicker({
            dateFormat: 'dd.mm.yy'
        });
    } );

    /*
     * Select - 2 search dropdown
     */

    $('.select-2').select2();
});
