$(document).ready(function(){
$("select:not(.none-select2)").select2();
});

function print_report(id) {
    let printed_div = document.getElementById(id);
    let printed_content = printed_div.innerHTML ;
    let old_body = $('body').html();
    $('body').html(printed_content);
    window.print();
    $('body').html(old_body);
}
