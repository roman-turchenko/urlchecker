$(document).ready(function(){

    $("div.check_code").bind({
        click: checkApplication
    });
});

function checkApplication( event ){

    var element = $(this);
    var wd_element = $(this).next("div.weight_diff");
    var params  = element.data('params');
    console.log( params.id_application +' '+ params.id_platform);
    updateApplicationCode(element, false);
    checkApplicationRequest( params.id_application, params.id_platform, element, wd_element );
}

function checkApplicationRequest( id_application, id_platform, element, wd_element ){

    if( id_application, id_platform ){

        var request_url = '?controller=api&action=getHTTPcode';
        $.post( request_url, {id_application: id_application, id_platform: id_platform}, function(data){

            console.log(data);
            updateApplicationCode(element, data.HTTP_code);
            updateWeightDiff( wd_element, data.weight_diff_kb );
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

function updateWeightDiff( element, weight_diff ){
    if( weight_diff !== 'undefined' ){
        element.html(weight_diff);
    }
}



