$(document).ready(function(){

    $("div.check_code").bind({
        click: checkApplication
    });
});

function checkApplication( event ){

    var element = $(this);
    var params  = element.data('params');
    console.log( params.id_application +' '+ params.id_platform);
    updateApplicationCode(element, false);
    checkApplicationRequest( params.id_application, params.id_platform, element );
}

function checkApplicationRequest( id_application, id_platform, element ){

    if( id_application, id_platform ){

        var request_url = '?controller=api&action=getHTTPcode';
        $.post( request_url, {id_application: id_application, id_platform: id_platform}, function(data){

            console.log(data);
            updateApplicationCode(element, data.HTTP_code);
            return {error:false}
        });
    }
    else
        return {error:true, message: 'empty required params'};
}

function updateApplicationCode( element, code ){
    if( code ){

        console.log('Updating code: '+code);
        element.html(code).removeClass('loading');
    }else{

        console.log('Loading code...');
        element.html('').addClass('loading');
    }
}



