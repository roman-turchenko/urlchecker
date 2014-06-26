$(document).ready(function(){

    checkHttpCode("http://www.yandex.ru");
});

function checkHttpCode( url ){
    $.post('?controller=apps&action=getHttpCode', {url:url}, function(data){ alert(data.code); });
}