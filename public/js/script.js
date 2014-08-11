
$( document ).ready(function() {
    $('.add-to-cart').click(function(){
        $('.loading-image').css('display', 'block');
        var url = '/cart/add-item/';
        var id = this.id.split('_');
        var data = {product_id: id[1]};
        request = $.ajax({
            url: url,
            type: "post",
            data: data
        });
        // callback handler that will be called on success
        request.done(function (){
            setTimeout(function() {
                $('.loading-image').css('display', 'none');
            },500);
        });
        // callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // log the error to the console
            console.error(
                "The following error occured: "+
                    textStatus, errorThrown
            );
        });
    })
});