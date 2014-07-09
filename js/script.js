$(document).ready(function(){

    /**
     * Check HTTP codes on load, on click
     */
    var http_codes = $("div.http_code");
    /*
    $.each(http_codes, function(k, v){
        checkHttpCode($(v).data('url'), v);
    });
    http_codes.click(function(){
        checkHttpCode($(this).data('url'), this);
    });
*/
});

/**
 * Ajax request for http code
 * @param url
 * @param conteiner
 */
function checkHttpCode( url, conteiner ){

    $(conteiner).html("&nbsp;").addClass("loading").removeClass("code"+$(conteiner).data('code'));
    $.post('?controller=apps&action=getHttpCode', {url:url}, function(data){
        $(conteiner).html(data.code).toggleClass("loading code"+data.code);
        $(conteiner).data('code', data.code);
    });
}