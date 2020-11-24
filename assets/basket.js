$(".add-basket-product-item").on("click", function (e){
    e.preventDefault();

    const link            = $(e.currentTarget);
    const productId       = link.data("product-id");
    const productQuantity = $("#add-basket-product-quantity-"+productId).val();

    $.ajax({
        type : "POST",
        url  : "basket/add",
        data : {
            "product_id"       : productId,
            "product_quantity" : productQuantity
        }
    }).done(function(data){
        console.log(data)

        if (typeof data.status != "undefined" && data.status != "undefined")
        {
            // At this point we know that the status is defined,
            // so we need to check for its value ("OK" in my case)
            if (data.status == "OK")
            {
                // At this point we know that the server response
                // is what we were expecting,
                // so retrive the response and use if

                if (typeof data.message != "undefined" && data.message != "undefined")
                {
                    // Do whatever you need with data.message
                }
            }
        }
    });
});